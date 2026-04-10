@extends('admin.layout')
@section('title', __('messages.subjects'))

@section('content')
<div class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.subjects') }}</h1>
        <a href="{{ route('admin.subjects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">{{ __('messages.new_subject') }}</a>
    </div>
    <div class="overflow-x-auto rounded-xl border border-slate-200/70 dark:border-slate-700">
    <table class="min-w-full text-sm text-slate-700 dark:text-slate-200">
        <thead class="bg-slate-50/90 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-900/70 dark:text-slate-400">
            <tr>
                <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">#</th>
                <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.subject_name') }}</th>
                <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.created_at_label') }}</th>
                <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.edit') }}</th>
                <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200/80 bg-white/70 dark:divide-slate-700/80 dark:bg-slate-800/70">
        @forelse($subjects as $subject)
            <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/30">
                <td class="px-4 py-2 text-center">{{ $subject->fan_id }}</td>
                <td class="px-4 py-2 text-center text-slate-900 dark:text-white">{{ $subject->fan }}</td>
                <td class="px-4 py-2 text-center">{{ $subject->created_at ? $subject->created_at->format('Y-m-d H:i') : '-' }}</td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('admin.subjects.edit', $subject->fan_id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">{{ __('messages.edit') }}</a>
                </td>
                <td class="px-4 py-2 text-center">
                    <form method="POST" action="{{ secure_route('admin.subjects.destroy', $subject->fan_id) }}" style="display:inline-block" onsubmit="return confirm(@js(__('messages.delete_subject_confirm')))">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">{{ __('messages.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-slate-500 dark:text-slate-400">{{ __('messages.no_subjects_admin') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
