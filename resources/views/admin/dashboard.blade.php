@extends('admin.layout')
@section('title', __('messages.admin_dashboard'))

@section('content')
<!-- Header Section -->
<div class="mb-8 flex flex-col justify-between border-b border-slate-200 pb-6 dark:border-slate-800 sm:flex-row sm:items-center">
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">{{ __('messages.admin_dashboard') }}</h1>
        <p class="mt-2 font-medium text-slate-500 dark:text-slate-400">{{ __('messages.admin_dashboard_subtitle') }}</p>
    </div>
</div>

<!-- Key Metrics Section -->
<div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2">
    <!-- Foydalanuvchilar Stat Card -->
    <div class="glass-panel group relative flex items-center gap-6 overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm transition-shadow hover:shadow-md dark:border-slate-700 dark:bg-slate-800/90">
        <!-- Decoration -->
        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-100/80 blur-2xl transition-colors group-hover:bg-blue-200 dark:bg-blue-500/20 dark:group-hover:bg-blue-400/30"></div>
        
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-500 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 transform group-hover:scale-105 transition-transform">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <div>
            <div class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">{{ $usersCount }}</div>
            <div class="mt-1 font-semibold text-slate-600 dark:text-slate-300">{{ __('messages.users_count') }}</div>
        </div>
    </div>

    <!-- Arizalar Stat Card -->
    <div class="glass-panel group relative flex items-center gap-6 overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm transition-shadow hover:shadow-md dark:border-slate-700 dark:bg-slate-800/90">
        <!-- Decoration -->
        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-amber-100/80 blur-2xl transition-colors group-hover:bg-amber-200 dark:bg-amber-500/20 dark:group-hover:bg-amber-400/30"></div>
        
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-400 flex items-center justify-center text-white shadow-lg shadow-amber-500/30 transform group-hover:scale-105 transition-transform">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <div class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">{{ $applicationsCount }}</div>
            <div class="mt-1 font-semibold text-slate-600 dark:text-slate-300">{{ __('messages.applications_count') }}</div>
        </div>
    </div>
</div>

<h2 class="mb-6 text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.quick_links') }}</h2>

<!-- Quick Links Section -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <!-- Foydalanuvchilar Link -->
    <a href="{{ route('admin.users') }}" class="group rounded-2xl border border-slate-200/80 bg-white/95 p-6 shadow-sm transition-all hover:border-blue-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-800/90 dark:hover:border-blue-500/40">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/15 dark:text-blue-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <h3 class="mb-2 text-lg font-bold text-slate-900 dark:text-white">{{ __('messages.users') }}</h3>
        <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">{{ __('messages.manage_users_desc') }}</p>
    </a>

    <!-- Dasturlar Link -->
    <a href="{{ route('admin.programs') }}" class="group rounded-2xl border border-slate-200/80 bg-white/95 p-6 shadow-sm transition-all hover:border-indigo-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-800/90 dark:hover:border-indigo-500/40">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 transition-colors group-hover:bg-indigo-600 group-hover:text-white dark:bg-indigo-500/15 dark:text-indigo-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h3 class="mb-2 text-lg font-bold text-slate-900 dark:text-white">{{ __('messages.programs') }}</h3>
        <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">{{ __('messages.manage_programs_desc') }}</p>
    </a>

    <!-- Arizalar Link -->
    <a href="{{ route('admin.applications') }}" class="group rounded-2xl border border-slate-200/80 bg-white/95 p-6 shadow-sm transition-all hover:border-amber-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-800/90 dark:hover:border-amber-500/40">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-50 text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white dark:bg-amber-500/15 dark:text-amber-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="mb-2 text-lg font-bold text-slate-900 dark:text-white">{{ __('messages.applications') }}</h3>
        <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">{{ __('messages.review_applications_desc') }}</p>
    </a>
</div>
@endsection
