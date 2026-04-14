<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-900">
    <div class="flex min-h-screen">
        <aside class="flex w-64 flex-col border-r border-slate-200 bg-slate-900 text-slate-300">
            <div class="flex h-14 items-center border-b border-slate-700/80 px-4">
                <span class="text-lg font-semibold tracking-tight text-white">{{ config('app.name') }}</span>
                <span class="ml-2 rounded bg-primary-600/90 px-2 py-0.5 text-xs font-medium text-white">Admin</span>
            </div>
            <nav class="flex-1 space-y-1 p-3" aria-label="Main navigation">
                <a
                    href="{{ url('/') }}"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->is('/') ? 'bg-primary-600 text-white shadow-sm ring-1 ring-primary-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <span class="h-1.5 w-1.5 rounded-full {{ request()->is('/') ? 'bg-white' : 'bg-slate-500' }}"></span>
                    Home
                </a>
                <a
                    href="{{ route('web.dashboard') }}"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('web.dashboard') ? 'bg-primary-600 text-white shadow-sm ring-1 ring-primary-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <span class="h-1.5 w-1.5 rounded-full {{ request()->routeIs('web.dashboard') ? 'bg-white' : 'bg-slate-500' }}"></span>
                    Dashboard
                </a>
                <a
                    href="{{ route('web.login') }}"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('web.login') ? 'bg-primary-600 text-white shadow-sm ring-1 ring-primary-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <span class="h-1.5 w-1.5 rounded-full {{ request()->routeIs('web.login') ? 'bg-white' : 'bg-slate-500' }}"></span>
                    Login
                </a>
                <a
                    href="{{ route('web.register') }}"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('web.register') ? 'bg-primary-600 text-white shadow-sm ring-1 ring-primary-500/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <span class="h-1.5 w-1.5 rounded-full {{ request()->routeIs('web.register') ? 'bg-white' : 'bg-slate-500' }}"></span>
                    Register
                </a>
            </nav>
            <div class="border-t border-slate-700/80 p-3">
                <p class="text-xs text-slate-500">Primary theme: <span class="font-medium text-primary-400">blue</span></p>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-14 shrink-0 items-center border-b border-slate-200 bg-white px-6 shadow-sm">
                <div class="flex flex-1 items-center gap-3">
                    <span class="hidden h-8 w-1 rounded-full bg-primary-600 sm:block" aria-hidden="true"></span>
                    <h1 class="truncate text-lg font-semibold text-slate-800">@yield('heading', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('web.login') }}" class="link-primary text-sm">Sign in</a>
                    <a href="{{ route('web.register') }}" class="rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                        Get started
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
