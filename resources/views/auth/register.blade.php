@extends('layouts.guest')

@section('title', 'Register — ' . config('app.name'))

@section('content')
    <div class="rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-xl shadow-primary-900/5 backdrop-blur-sm">
        <h2 class="text-center text-2xl font-bold tracking-tight text-slate-900">Create account</h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Already registered?
            <a href="{{ route('web.login') }}" class="link-primary font-semibold">Sign in</a>
        </p>

        <form class="mt-8 space-y-5" action="#" method="post">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    required
                    class="input-primary mt-1"
                    placeholder="Your name"
                >
            </div>
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
                    autocomplete="new-password"
                    required
                    class="input-primary mt-1"
                >
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    required
                    class="input-primary mt-1"
                >
            </div>
            <button type="submit" class="btn-primary w-full">
                Create account
            </button>
        </form>
    </div>
@endsection
