<?php

namespace Database\Seeders;

use App\Models\Snippet;
use Illuminate\Database\Seeder;

class SnippetSeeder extends Seeder
{
    public function run(): void
    {
        $snippets = [
            [
                'title' => 'Atomic Database Transactions with Retry Backoff',
                'slug' => 'atomic-database-transactions-with-retry-backoff',
                'category' => 'Laravel',
                'language' => 'php',
                'description' => 'Safely execute dead-lock prone SQL transactions with automatic linear backoff and rollback telemetry.',
                'code_content' => "<?php\n\nuse Illuminate\Support\Facades\DB;\n\nfunction executeAtomicWithRetry(callable \$callback, int \$maxAttempts = 5): mixed\n{\n    return DB::transaction(function () use (\$callback) {\n        return \$callback();\n    }, \$maxAttempts);\n}",
                'is_active' => true,
            ],
            [
                'title' => 'Custom Reactive Debounce Hook in TypeScript',
                'slug' => 'custom-reactive-debounce-hook-in-typescript',
                'category' => 'TypeScript',
                'language' => 'typescript',
                'description' => 'Lightweight typed debounce utility with immediate invocation support and cancellation handles.',
                'code_content' => "import { useState, useEffect } from 'react';\n\nexport function useDebounce<T>(value: T, delay: number): T {\n  const [debouncedValue, setDebouncedValue] = useState<T>(value);\n\n  useEffect(() => {\n    const handler = setTimeout(() => {\n      setDebouncedValue(value);\n    }, delay);\n\n    return () => {\n      clearTimeout(handler);\n    };\n  }, [value, delay]);\n\n  return debouncedValue;\n}",
                'is_active' => true,
            ],
            [
                'title' => 'Strict API Response Helper for Laravel 11/12',
                'slug' => 'strict-api-response-helper-laravel',
                'category' => 'API Design',
                'language' => 'php',
                'description' => 'Standardized JSON envelope pattern with error payload normalization, metadata pagination, and HTTP status constraints.',
                'code_content' => "<?php\n\nnamespace App\Http\Responses;\n\nuse Illuminate\Http\JsonResponse;\n\nclass ApiResponse\n{\n    public static function success(mixed \$data = [], string \$message = 'Success', int \$code = 200): JsonResponse\n    {\n        return response()->json([\n            'success' => true,\n            'message' => \$message,\n            'data' => \$data,\n        ], \$code);\n    }\n\n    public static function error(string \$message, int \$code = 400, mixed \$errors = null): JsonResponse\n    {\n        return response()->json([\n            'success' => false,\n            'message' => \$message,\n            'errors' => \$errors,\n        ], \$code);\n    }\n}",
                'is_active' => true,
            ],
        ];

        foreach ($snippets as $snippetData) {
            Snippet::updateOrCreate(
                ['slug' => $snippetData['slug']],
                $snippetData
            );
        }
    }
}

