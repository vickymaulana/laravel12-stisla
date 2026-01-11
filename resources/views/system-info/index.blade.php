@extends('layouts.app')

@section('title', 'System Information')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>System Information</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">System Information</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Environment & Configuration</h2>
                <p class="section-lead">
                    Check your system environment and configuration details.
                </p>

                <div class="row">
                    <!-- PHP Information -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fab fa-php"></i> PHP Information</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td><strong>PHP Version</strong></td>
                                        <td>{{ $systemInfo['php']['version'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Memory Limit</strong></td>
                                        <td>{{ $systemInfo['php']['memory_limit'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Max Execution Time</strong></td>
                                        <td>{{ $systemInfo['php']['max_execution_time'] }}s</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Upload Max Filesize</strong></td>
                                        <td>{{ $systemInfo['php']['upload_max_filesize'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Post Max Size</strong></td>
                                        <td>{{ $systemInfo['php']['post_max_size'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Laravel Information -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fab fa-laravel"></i> Laravel Information</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td><strong>Laravel Version</strong></td>
                                        <td>{{ $systemInfo['laravel']['version'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Environment</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $systemInfo['laravel']['environment'] === 'production' ? 'danger' : 'warning' }}">
                                                {{ strtoupper($systemInfo['laravel']['environment']) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Debug Mode</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $systemInfo['laravel']['debug_mode'] ? 'danger' : 'success' }}">
                                                {{ $systemInfo['laravel']['debug_mode'] ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Timezone</strong></td>
                                        <td>{{ $systemInfo['laravel']['timezone'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Locale</strong></td>
                                        <td>{{ $systemInfo['laravel']['locale'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Database Information -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-database"></i> Database Information</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td><strong>Connection</strong></td>
                                        <td>{{ $systemInfo['database']['connection'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Driver</strong></td>
                                        <td>{{ $systemInfo['database']['driver'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Database</strong></td>
                                        <td>{{ $systemInfo['database']['database'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $systemInfo['database']['status'] === 'Connected' ? 'success' : 'danger' }}">
                                                {{ $systemInfo['database']['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Server Information -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-server"></i> Server Information</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td><strong>Operating System</strong></td>
                                        <td>{{ $systemInfo['server']['os'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Server Software</strong></td>
                                        <td>{{ $systemInfo['server']['server_software'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Document Root</strong></td>
                                        <td><small>{{ $systemInfo['server']['document_root'] }}</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Storage Information -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-hdd"></i> Storage Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <table class="table table-striped">
                                            <tr>
                                                <td><strong>Storage Writable</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $systemInfo['storage']['storage_writable'] ? 'success' : 'danger' }}">
                                                        {{ $systemInfo['storage']['storage_writable'] ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Cache Writable</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $systemInfo['storage']['cache_writable'] ? 'success' : 'danger' }}">
                                                        {{ $systemInfo['storage']['cache_writable'] ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table table-striped">
                                            <tr>
                                                <td><strong>Logs Writable</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $systemInfo['storage']['logs_writable'] ? 'success' : 'danger' }}">
                                                        {{ $systemInfo['storage']['logs_writable'] ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Storage Path</strong></td>
                                                <td><small>{{ $systemInfo['storage']['storage_path'] }}</small></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table table-striped">
                                            <tr>
                                                <td><strong>Free Space</strong></td>
                                                <td>{{ $systemInfo['storage']['disk_free_space'] }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Space</strong></td>
                                                <td>{{ $systemInfo['storage']['disk_total_space'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PHP Extensions -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-puzzle-piece"></i> PHP Extensions ({{ count($systemInfo['php']['extensions']) }} loaded)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($systemInfo['php']['extensions'] as $extension)
                                        <div class="col-md-2 col-sm-4 col-6 mb-2">
                                            <span class="badge badge-light">{{ $extension }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
