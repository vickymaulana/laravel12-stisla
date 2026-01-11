<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SystemInfoController extends Controller
{
    /**
     * Display system information.
     */
    public function index()
    {
        $systemInfo = [
            'php' => [
                'version' => PHP_VERSION,
                'extensions' => get_loaded_extensions(),
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ],
            'laravel' => [
                'version' => app()->version(),
                'environment' => app()->environment(),
                'debug_mode' => config('app.debug'),
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
            ],
            'database' => [
                'connection' => config('database.default'),
                'driver' => config('database.connections.' . config('database.default') . '.driver'),
                'database' => config('database.connections.' . config('database.default') . '.database'),
            ],
            'server' => [
                'os' => PHP_OS,
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
            ],
            'storage' => [
                'storage_path' => storage_path(),
                'storage_writable' => is_writable(storage_path()),
                'cache_writable' => is_writable(storage_path('framework/cache')),
                'logs_writable' => is_writable(storage_path('logs')),
            ],
        ];

        // Check database connection
        try {
            DB::connection()->getPdo();
            $systemInfo['database']['status'] = 'Connected';
        } catch (\Exception $e) {
            $systemInfo['database']['status'] = 'Failed: ' . $e->getMessage();
        }

        // Get disk space
        $systemInfo['storage']['disk_free_space'] = $this->formatBytes(disk_free_space(base_path()));
        $systemInfo['storage']['disk_total_space'] = $this->formatBytes(disk_total_space(base_path()));

        return view('system-info.index', compact('systemInfo'));
    }

    /**
     * Format bytes to human readable format.
     */
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
