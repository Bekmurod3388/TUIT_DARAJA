@extends('admin.layout')
@section('title', __('messages.new_academic_year'))

@section('content')
<div class="mx-auto max-w-lg rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.new_academic_year') }}</h1>
    <form method="POST" action="{{ secure_route('admin.academic-years.store') }}">
        @csrf
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.academic_year') }}</label>
            <input type="text" name="name" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('name') }}" placeholder="2025/2026">
        </div>
        <div class="mb-6">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.semester') }}</label>
            <select name="semester" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required>
                <option value="">{{ __('messages.select') }}</option>
                <option value="bahorgi" @selected(old('semester') === 'bahorgi')>{{ __('messages.spring_semester') }}</option>
                <option value="kuzgi" @selected(old('semester') === 'kuzgi')>{{ __('messages.fall_semester') }}</option>
            </select>
        </div>
        <label class="mb-6 flex items-center gap-2 text-slate-900 dark:text-white">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('is_active'))>
            <span class="font-semibold">{{ __('messages.set_as_active_academic_year') }}</span>
        </label>
        <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">{{ __('messages.save_changes') }}</button>
        <a href="{{ route('admin.academic-years.index') }}" class="ml-4 text-slate-600 hover:underline dark:text-slate-400">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
