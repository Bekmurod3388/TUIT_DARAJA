@extends('admin.layout')
@section('title', __('messages.edit_subject'))

@section('content')
<div class="mx-auto max-w-lg rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.edit_subject') }}</h1>
    <form method="POST" action="{{ route('admin.subjects.update', $subject->fan_id) }}">
        @csrf
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.subject_name') }}</label>
            <input type="text" name="fan" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required value="{{ old('fan', $subject->fan) }}">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">{{ __('messages.save_changes') }}</button>
        <a href="{{ route('admin.subjects') }}" class="ml-4 text-slate-600 hover:underline dark:text-slate-400">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
