@extends('admin.layout')
@section('title', __('messages.applications'))

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
@endphp
<div class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-4 text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.applications') }}</h1>
    <div class="overflow-x-auto rounded-xl border border-slate-200/70 dark:border-slate-700">
    <table class="w-full table-auto text-sm text-slate-700 dark:text-slate-200">
        <thead class="sticky top-0 z-10 bg-slate-50/90 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-900/70 dark:text-slate-400">
            <tr>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.full_name') }}</th>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.phone_number') }}</th>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.specialization') }}</th>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.details') }}</th>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.status') }}</th>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.action') }}</th>
                <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.created_at_label') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200/80 bg-white/70 dark:divide-slate-700/80 dark:bg-slate-800/70">
        @forelse($applications as $app)
            <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/30">
                <td class="px-4 py-3 text-center font-medium text-slate-900 dark:text-white">{{ $app->last_name }} {{ $app->first_name }} {{ $app->middle_name }}</td>
                <td class="px-4 py-3 text-center">{{ $app->phone }}</td>
                <td class="px-4 py-3 text-center">{{ $app->specalization->name ?? '-' }}</td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('admin.applications.show', $app->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">{{ __('messages.details') }}</a>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="inline-block min-w-[120px] rounded px-6 py-3 text-center text-base font-semibold {{ $statusColors[$app->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200' }}">
                        {{ $statusLabels[$app->status] ?? __('messages.status_pending') }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    @if($app->is_scored)
                        <span class="inline-block rounded px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300">{{ __('messages.score_with_value', ['value' => $app->score]) }}</span>
                    @else
                        <form method="POST" action="{{ secure_route('admin.applications.setScore', $app->id) }}" class="flex items-center gap-2 justify-center">
                            @csrf
                            <input type="number" name="score" min="0" max="100" class="w-20 rounded border border-slate-300 bg-white px-2 py-1 text-center text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" placeholder="{{ __('messages.score') }}" required>
                            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-1 rounded font-semibold">{{ __('messages.set_score') }}</button>
                        </form>
                    @endif
                </td>
                <td class="px-4 py-3 text-center flex gap-2 justify-center">
                    <form method="POST" action="{{ secure_route('admin.applications.updateStatus', $app->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-base font-semibold" @if($app->status === 'accepted') disabled @endif>{{ __('messages.accept') }}</button>
                    </form>
                    <form method="POST" action="{{ secure_route('admin.applications.updateStatus', $app->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-base font-semibold" @if($app->status === 'cancelled') disabled @endif>{{ __('messages.reject') }}</button>
                    </form>
                </td>
                <td class="px-4 py-3 text-center">{{ $app->created_at ? $app->created_at->format('Y-m-d H:i') : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-6 text-center text-slate-500 dark:text-slate-400">{{ __('messages.no_admin_applications') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
