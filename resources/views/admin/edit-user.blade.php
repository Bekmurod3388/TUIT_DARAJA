@extends('admin.layout')
@section('title', __('messages.edit_user'))

@section('content')
<div class="mx-auto max-w-xl rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.edit_user') }}</h1>
    <form method="POST" action="{{ route('admin.users.update', $editUser->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.last_name') }}</label>
            <input type="text" name="last_name" class="form-input h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-lg text-slate-800 focus:border-blue-500 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('last_name', $editUser->last_name) }}">
        </div>
        <div>
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.first_name') }}</label>
            <input type="text" name="first_name" class="form-input h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-lg text-slate-800 focus:border-blue-500 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('first_name', $editUser->first_name) }}">
        </div>
        <div>
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.middle_name') }}</label>
            <input type="text" name="middle_name" class="form-input h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-lg text-slate-800 focus:border-blue-500 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('middle_name', $editUser->middle_name) }}">
        </div>
        <div>
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.phone_number') }}</label>
            <input type="text" name="phone" class="form-input h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-lg text-slate-800 focus:border-blue-500 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('phone', $editUser->phone) }}">
        </div>
        <div>
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.role') }}</label>
            <input type="text" name="role" class="form-input h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-lg text-slate-800 focus:border-blue-500 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" value="{{ old('role', $editUser->role) }}">
        </div>
        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">{{ __('messages.save_changes') }}</button>
            <a href="{{ route('admin.users') }}" class="rounded-xl bg-slate-200 px-10 py-3 text-lg font-bold text-slate-800 shadow transition-colors hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
