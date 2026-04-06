@extends('admin.layout')
@section('title', __('messages.new_program_name'))

@section('content')
<div class="mx-auto mt-8 max-w-lg rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.new_program_name') }}</h1>
    <form action="{{ route('admin.program-names.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('messages.program_name') }}</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 focus:border-amber-500 focus:ring-amber-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" value="{{ old('name') }}" required maxlength="255" placeholder="{{ __('messages.example_program_name') }}">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="code" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('messages.program_code') }}</label>
            <input type="text" name="code" id="code" class="form-input mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 focus:border-amber-500 focus:ring-amber-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" value="{{ old('code') }}" required maxlength="255" placeholder="{{ __('messages.example_program_code') }}">
            @error('code')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.program-names.index') }}" class="text-slate-600 hover:underline dark:text-slate-400">{{ __('messages.back') }}</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold shadow">{{ __('messages.save_changes') }}</button>
        </div>
    </form>
</div>
@endsection
