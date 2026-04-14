<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-primary-50/40 to-primary-100/60 font-sans antialiased text-slate-900">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <a href="{{ url('/') }}" class="mb-8 flex items-center gap-2 text-lg font-semibold text-primary-700 transition hover:text-primary-600">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-600 text-sm font-bold text-white shadow-md shadow-primary-600/25">A</span>
            {{ config('app.name') }}
        </a>
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </div>
</body>
</html>
