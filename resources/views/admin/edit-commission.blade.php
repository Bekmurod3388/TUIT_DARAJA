@extends('admin.layout')
@section('title', __('messages.edit_commission'))

@section('content')
@php
    $membersText = old('members');
    if (is_array($membersText)) {
        $membersText = implode(', ', $membersText);
    } elseif ($membersText === null) {
        $membersText = is_array($commission->members) ? implode(', ', $commission->members) : $commission->members;
    }
@endphp
<div class="mx-auto max-w-lg rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.edit_commission') }}</h1>
    <form method="POST" action="{{ route('admin.commissions.update', $commission->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.chairman') }}</label>
            <input type="text" name="chairman" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('chairman', $commission->chairman) }}">
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.deputy') }}</label>
            <input type="text" name="deputy" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('deputy', $commission->deputy) }}">
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.secretary') }}</label>
            <input type="text" name="secretary" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('secretary', $commission->secretary) }}">
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.program_name') }}</label>
            <select name="specalization_id" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required>
                <option value="">{{ __('messages.select') }}</option>
                @foreach($specalizations as $spec)
                    <option value="{{ $spec->id }}" @selected(old('specalization_id', $commission->specalization_id) == $spec->id)>{{ $spec->name }} ({{ $spec->code }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.commission_members') }}</label>
            <textarea name="members" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" rows="3" required placeholder="{{ __('messages.members_placeholder') }}">{{ $membersText }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">{{ __('messages.save_changes') }}</button>
        <a href="{{ route('admin.commissions') }}" class="ml-4 text-slate-600 hover:underline dark:text-slate-400">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
