<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title') &mdash; Laravel - Stisla</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme ?? (prefersDark ? 'dark' : 'light');

            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- Custom CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/reverse.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">

    <!-- Additional CSS (if any) -->
    @stack('style')
    @stack('css')
</head>
<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.header')

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Main Content -->
            @hasSection('main')
                @yield('main')
            @else
                <div class="main-content">
                    @yield('content')
                </div>
            @endif

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>

    <!-- jQuery (required by Stisla scripts) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Custom JS Libraries -->
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>

    <!-- Template JS Files -->
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @livewireScripts

    <script>
        // Compatibility shim for older Bootstrap 4 data attributes in existing templates.
        document.querySelectorAll('[data-toggle]').forEach((el) => {
            if (!el.hasAttribute('data-bs-toggle')) {
                el.setAttribute('data-bs-toggle', el.getAttribute('data-toggle'));
            }
        });

        document.querySelectorAll('[data-target]').forEach((el) => {
            if (!el.hasAttribute('data-bs-target')) {
                el.setAttribute('data-bs-target', el.getAttribute('data-target'));
            }
        });

        document.querySelectorAll('[data-dismiss]').forEach((el) => {
            if (!el.hasAttribute('data-bs-dismiss')) {
                el.setAttribute('data-bs-dismiss', el.getAttribute('data-dismiss'));
            }
        });
    </script>

    <!-- Additional JS (if any) -->
    @stack('scripts')
</body>
</html>
