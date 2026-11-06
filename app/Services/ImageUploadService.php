<?php

namespace App\Services;

use finfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageUploadService
{
    protected array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/jpg',
        'image/gif',
        'image/svg+xml',
    ];

    /**
     * Max dimension (width or height) to resize down to for optimal size reduction.
     */
    protected int $maxDimension = 1920;

    /**
     * Default WebP compression quality (80 yields huge reduction with virtually no visible loss).
     */
    protected int $webpQuality = 80;

    /**
     * Upload an image, convert it to WebP format, reduce its dimension and file size, and store it.
     */
    public function upload(
        UploadedFile $file,
        string $directory = 'images',
        bool $useMagick = false
    ): string {
        $this->validateFile($file);

        // Ensure directory starts with uploads/
        $cleanDir = trim($directory, '/');
        $uploadSubDir = str_starts_with($cleanDir, 'uploads') ? $cleanDir : 'uploads/'.$cleanDir;
        $targetPath = public_path($uploadSubDir);

        if (! file_exists($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        $mime = $this->detectMimeType($file);

        // SVGs are vector XML and should be stored intact with sanitized extension
        if ($mime === 'image/svg+xml') {
            $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.svg';
            $file->move($targetPath, $filename);
            return $uploadSubDir.'/'.$filename;
        }

        // Generate .webp filename
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        if (empty($baseName)) {
            $baseName = 'img';
        }
        $filename = time().'_'.$baseName.'.webp';
        $destinationFile = $targetPath.'/'.$filename;

        // Convert to WebP and compress
        $converted = $this->convertAndCompressToWebp($file->getRealPath(), $destinationFile, $mime);

        if (! $converted) {
            // Fallback: move file directly if GD fails
            $fallbackExt = $file->getClientOriginalExtension() ?: 'png';
            $filename = time().'_'.$baseName.'.'.$fallbackExt;
            $file->move($targetPath, $filename);
        }

        return $uploadSubDir.'/'.$filename;
    }

    /**
     * Replace an existing image.
     */
    public function replace(
        UploadedFile $file,
        ?string $oldPath = null,
        string $directory = 'images',
        bool $useMagick = false
    ): string {
        $newPath = $this->upload($file, $directory, $useMagick);

        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $newPath;
    }

    /**
     * Delete an image.
     */
    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        // Remove from public/ directory
        $publicFilePath = public_path(ltrim($path, '/'));
        if (file_exists($publicFilePath) && is_file($publicFilePath)) {
            @unlink($publicFilePath);
            return;
        }

        // Fallback for Storage disk public
        $disk = Storage::disk('public');
        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    /**
     * Converts any raster image (JPEG, PNG, GIF, WebP) to WebP format,
     * downsizes dimensions if larger than maxDimension, and applies optimal quality.
     */
    protected function convertAndCompressToWebp(string $sourcePath, string $destinationPath, string $mime): bool
    {
        if (! function_exists('imagewebp')) {
            return false;
        }

        $image = null;

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                if (function_exists('imagecreatefromjpeg')) {
                    $image = @imagecreatefromjpeg($sourcePath);
                }
                break;

            case 'image/png':
                if (function_exists('imagecreatefrompng')) {
                    $image = @imagecreatefrompng($sourcePath);
                }
                break;

            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $image = @imagecreatefromwebp($sourcePath);
                }
                break;

            case 'image/gif':
                if (function_exists('imagecreatefromgif')) {
                    $image = @imagecreatefromgif($sourcePath);
                }
                break;

            default:
                if (function_exists('imagecreatefromstring')) {
                    $contents = @file_get_contents($sourcePath);
                    if ($contents) {
                        $image = @imagecreatefromstring($contents);
                    }
                }
                break;
        }

        if (! $image) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        // Auto-orient JPEG if EXIF is available
        if (function_exists('exif_read_data') && ($mime === 'image/jpeg' || $mime === 'image/jpg')) {
            $exif = @exif_read_data($sourcePath);
            if (! empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $image = imagerotate($image, 180, 0);
                        break;
                    case 6:
                        $image = imagerotate($image, -90, 0);
                        $width = imagesx($image);
                        $height = imagesy($image);
                        break;
                    case 8:
                        $image = imagerotate($image, 90, 0);
                        $width = imagesx($image);
                        $height = imagesy($image);
                        break;
                }
            }
        }

        // Calculate proportional downscaled dimensions
        $targetWidth = $width;
        $targetHeight = $height;

        if ($width > $this->maxDimension || $height > $this->maxDimension) {
            if ($width >= $height) {
                $targetWidth = $this->maxDimension;
                $targetHeight = (int) round(($height / $width) * $this->maxDimension);
            } else {
                $targetHeight = $this->maxDimension;
                $targetWidth = (int) round(($width / $height) * $this->maxDimension);
            }
        }

        // Create new truecolor canvas
        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        // Preserve alpha transparency for PNG / WebP / GIF
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);

        // Resample with antialiasing / bicubic interpolation
        imagecopyresampled(
            $canvas,
            $image,
            0, 0, 0, 0,
            $targetWidth,
            $targetHeight,
            $width,
            $height
        );

        // Save as WebP with optimized quality
        $result = imagewebp($canvas, $destinationPath, $this->webpQuality);

        return $result && file_exists($destinationPath) && filesize($destinationPath) > 0;
    }

    protected function validateFile(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw ValidationException::withMessages([
                'image' => 'The uploaded file is invalid.',
            ]);
        }

        $mime = $this->detectMimeType($file);

        if (! in_array($mime, $this->allowedMimeTypes, true)) {
            throw ValidationException::withMessages([
                'image' => 'Unsupported image format.',
            ]);
        }
    }

    protected function detectMimeType(UploadedFile $file): string
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mime = $finfo->file($file->getRealPath());

        if (! $mime) {
            throw ValidationException::withMessages([
                'image' => 'Unable to determine image type.',
            ]);
        }

        return $mime;
    }
}
