@extends('layouts.app')

@section('title', 'Dashboard — ' . config('app.name'))

@section('heading', 'Dashboard')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-slate-600">
            This page uses the main layout with a <strong class="text-primary-700">blue primary</strong> sidebar and navbar accents.
        </p>
        <p class="mt-4 text-sm text-slate-500">
            Filament admin at <a href="{{ url('/admin') }}" class="link-primary">/admin</a> also uses the same blue primary theme.
        </p>
    </div>
@endsection
