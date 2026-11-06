<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminBackupController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $user = Auth::user();
        $profile = $user ? $user->profile : null;

        $driver = config('database.default');
        $dbPath = config("database.connections.{$driver}.database");

        $dbSize = 0;
        if ($driver === 'sqlite' && file_exists($dbPath)) {
            $dbSize = filesize($dbPath);
        }

        $tableCount = 0;
        try {
            if ($driver === 'sqlite') {
                $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                $tableCount = count($tables);
            } else {
                $tables = DB::select('SHOW TABLES');
                $tableCount = count($tables);
            }
        } catch (\Throwable $e) {
            $tableCount = 0;
        }

        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $files = File::files($backupDir);
        $backups = [];

        foreach ($files as $file) {
            $name = $file->getFilename();
            if (str_starts_with($name, 'backup-') && (str_ends_with($name, '.sqlite') || str_ends_with($name, '.sql'))) {
                $backups[] = [
                    'filename' => $name,
                    'size' => $this->formatBytes($file->getSize()),
                    'raw_size' => $file->getSize(),
                    'created_at' => date('M d, Y H:i:s', $file->getMTime()),
                    'timestamp' => $file->getMTime(),
                ];
            }
        }

        usort($backups, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        $dbInfo = [
            'connection' => strtoupper($driver),
            'database_path' => $dbPath,
            'size' => $this->formatBytes($dbSize),
            'table_count' => $tableCount,
            'total_backups' => count($backups),
        ];

        return view('admin.backup', compact('page', 'profile', 'backups', 'dbInfo'));
    }

    public function create()
    {
        $driver = config('database.default');
        $dbPath = config("database.connections.{$driver}.database");
        $backupDir = storage_path('app/backups');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $extension = ($driver === 'sqlite') ? 'sqlite' : 'sql';
        $filename = 'backup-' . date('Y-m-d-His') . '.' . $extension;
        $destination = $backupDir . '/' . $filename;

        if ($driver === 'sqlite') {
            if (!file_exists($dbPath)) {
                return redirect()->back()->with('error', 'Database file does not exist.');
            }
            copy($dbPath, $destination);
        } else {
            // Non-sqlite SQL dump generation
            $sqlContent = "-- Database Backup generated on " . date('Y-m-d H:i:s') . "\n\n";
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $tableObj) {
                $table = current((array)$tableObj);
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                $sqlContent .= $createTable[0]->{'Create Table'} . ";\n\n";
                $rows = DB::table($table)->get();
                foreach ($rows as $row) {
                    $values = array_map(function ($val) {
                        return is_null($val) ? 'NULL' : DB::getPdo()->quote($val);
                    }, (array)$row);
                    $sqlContent .= "INSERT INTO `{$table}` VALUES (" . implode(', ', $values) . ");\n";
                }
                $sqlContent .= "\n";
            }
            file_put_contents($destination, $sqlContent);
        }

        return redirect()->route('backup.admin')->with('success', "Database snapshot created successfully: {$filename}");
    }

    public function download(string $filename)
    {
        $filename = basename($filename);
        $filePath = storage_path('app/backups/' . $filename);

        if (!File::exists($filePath)) {
            abort(404, 'Backup file not found.');
        }

        return response()->download($filePath);
    }

    public function destroy(string $filename)
    {
        $filename = basename($filename);
        $filePath = storage_path('app/backups/' . $filename);

        if (File::exists($filePath)) {
            File::delete($filePath);
            return redirect()->route('backup.admin')->with('success', 'Backup snapshot deleted successfully.');
        }

        return redirect()->route('backup.admin')->with('error', 'Backup file not found.');
    }

    public function restore(string $filename)
    {
        $filename = basename($filename);
        $backupFile = storage_path('app/backups/' . $filename);

        if (!File::exists($backupFile)) {
            return redirect()->route('backup.admin')->with('error', 'Backup file not found.');
        }

        $driver = config('database.default');
        $dbPath = config("database.connections.{$driver}.database");
        $backupDir = storage_path('app/backups');

        if ($driver === 'sqlite') {
            // Create a safety backup before restoring
            if (file_exists($dbPath)) {
                $safetyFile = $backupDir . '/backup-pre-restore-' . date('Y-m-d-His') . '.sqlite';
                copy($dbPath, $safetyFile);
            }

            copy($backupFile, $dbPath);
        } else {
            // Non-sqlite SQL script execution
            $sql = file_get_contents($backupFile);
            DB::unprepared($sql);
        }

        return redirect()->route('backup.admin')->with('success', "Database restored successfully from snapshot: {$filename}");
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
