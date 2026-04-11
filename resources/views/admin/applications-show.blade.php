@extends('admin.layout')
@section('title', __('messages.application_details'))

@section('content')
@php
    $statusLabels = [
        'pending' => __('messages.status_pending'),
        'accepted' => __('messages.status_accepted'),
        'cancelled' => __('messages.status_cancelled'),
        'in_process' => __('messages.status_in_process'),
    ];
    $statusColors = [
        'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300',
        'accepted' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300',
        'cancelled' => 'bg-rose-100 text-rose-800 dark:bg-rose-500/15 dark:text-rose-300',
        'in_process' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/15 dark:text-blue-300',
    ];
    $files = [
        'oac_file' => __('messages.oac_file'),
        'direction_file' => __('messages.direction_file'),
        'receipt_file' => __('messages.receipt_file'),
        'work_order_file' => __('messages.work_order_file'),
    ];
@endphp
<div class="mx-auto max-w-2xl rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.application_details') }}</h1>
    <div class="space-y-4 text-lg text-slate-700 dark:text-slate-200">
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.full_name') }}:</span> {{ $application->last_name }} {{ $application->first_name }} {{ $application->middle_name }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.phone_number') }}:</span> {{ $application->phone }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.specialization') }}:</span> {{ $application->specalization->name ?? '-' }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.academic_year') }}:</span> {{ $application->academicYear->name ?? '-' }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.semester') }}:</span> {{ $application->academicYear?->semester === 'bahorgi' ? __('messages.spring_semester') : ($application->academicYear?->semester === 'kuzgi' ? __('messages.fall_semester') : '-') }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.organization') }}:</span> {{ $application->organization }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.subject_name') }}:</span> {{ $application->subject }}</div>
        <div><span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.education_type') }}:</span> {{ $application->education_type }}</div>
        <div>
            <span class="font-semibold text-slate-900 dark:text-white">{{ __('messages.status') }}:</span>
            <span class="rounded px-3 py-2 text-base font-semibold {{ $statusColors[$application->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200' }}">
                {{ $statusLabels[$application->status] ?? __('messages.status_pending') }}
            </span>
        </div>
        @foreach ($files as $field => $label)
            <div>
                <span class="font-semibold text-slate-900 dark:text-white">{{ $label }}:</span>
                @if($application->{$field})
                    <a href="{{ route('applications.file', ['id' => $application->id, 'field' => $field]) }}" class="text-blue-600 underline dark:text-blue-400">
                        {{ __('messages.download') }}
                    </a>
                @else
                    -
                @endif
            </div>
        @endforeach
    </div>
    <div class="mt-8">
        <a href="{{ route('admin.applications') }}" class="inline-flex rounded-lg bg-slate-200 px-6 py-2 font-semibold text-slate-800 transition-colors hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">{{ __('messages.back') }}</a>
    </div>
</div>
@endsection
