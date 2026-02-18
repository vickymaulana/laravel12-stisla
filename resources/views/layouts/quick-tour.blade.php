@extends('layouts.app')

@section('title', 'Quick Tour')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Quick Tour</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Suggested Routes</h4>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><a href="{{ route('table.example') }}">Table Example</a></li>
                        <li><a href="{{ route('form.example') }}">Form Example</a></li>
                        <li><a href="{{ route('file-manager.index') }}">File Manager</a></li>
                        <li><a href="{{ route('notifications.index') }}">Notifications</a></li>
                        <li><a href="{{ route('settings.index') }}">Settings (superadmin)</a></li>
                        <li><a href="{{ route('activity-logs.index') }}">Activity Logs (superadmin)</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
