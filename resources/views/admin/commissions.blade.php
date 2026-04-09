@extends('admin.layout')
@section('title', __('messages.commissions'))

@section('content')
<div class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-4 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.commissions') }}</h1>
    <div class="overflow-x-auto rounded-xl border border-slate-200/70 dark:border-slate-700">
        <table class="min-w-full text-sm text-slate-700 dark:text-slate-200">
            <thead class="bg-slate-50/90 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-900/70 dark:text-slate-400">
                <tr>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">#</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.specialization') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.chairman') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.deputy') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.secretary') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.commission_members') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.created_at_label') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.edit') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.delete') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200/80 bg-white/70 dark:divide-slate-700/80 dark:bg-slate-800/70">
            @forelse($commissions as $commission)
                @php
                    $members = is_array($commission->members)
                        ? $commission->members
                        : (json_decode((string) $commission->members, true) ?: []);
                @endphp
                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/30">
                    <td class="px-4 py-2 text-center">{{ $commission->id }}</td>
                    <td class="px-4 py-2 text-center text-slate-900 dark:text-white">{{ $commission->specalization->name ?? '-' }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->chairman }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->deputy }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->secretary }}</td>
                    <td class="px-4 py-2 text-center">
                        @if($members !== [])
                            @foreach($members as $member)
                                <span class="mr-1 mb-1 inline-block rounded px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-500/15 dark:text-blue-300">{{ $member }}</span>
                            @endforeach
                        @else
                            <span class="text-slate-400 dark:text-slate-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center">{{ $commission->created_at ? $commission->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('admin.commissions.edit', $commission->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">{{ __('messages.edit') }}</a>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <form method="POST" action="{{ secure_url(route('admin.commissions.destroy', $commission->id, false)) }}" onsubmit="return confirm(@js(__('messages.delete_commission_confirm')))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="py-6 text-center text-slate-500 dark:text-slate-400">{{ __('messages.no_commissions') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
