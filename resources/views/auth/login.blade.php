@extends('layouts.guest')

@section('title', 'Login — ' . config('app.name'))

@section('content')
    <div class="rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-xl shadow-primary-900/5 backdrop-blur-sm">
        <h2 class="text-center text-2xl font-bold tracking-tight text-slate-900">Sign in</h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Don’t have an account?
            <a href="{{ route('web.register') }}" class="link-primary font-semibold">Register</a>
        </p>

        <form class="mt-8 space-y-6" action="#" method="post">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    class="input-primary mt-1"
                    placeholder="you@example.com"
                >
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    class="input-primary mt-1"
                >
            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    Remember me
                </label>
                <a href="#" class="link-primary text-sm">Forgot password?</a>
            </div>
            <button type="submit" class="btn-primary w-full">
                Sign in
            </button>
        </form>
    </div>
@endsection
