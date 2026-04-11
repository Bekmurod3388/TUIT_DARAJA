@extends('admin.layout')
@section('title', __('messages.academic_years'))

@section('content')
<div class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.academic_years') }}</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('messages.manage_academic_years_desc') }}</p>
        </div>
        <a href="{{ route('admin.academic-years.create') }}" class="rounded-lg bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
            {{ __('messages.new_academic_year') }}
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200/70 dark:border-slate-700">
        <table class="min-w-full text-sm text-slate-700 dark:text-slate-200">
            <thead class="bg-slate-50/90 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-900/70 dark:text-slate-400">
                <tr>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">#</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.academic_year') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.semester') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.active') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.created_at_label') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.edit') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.delete') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200/80 bg-white/70 dark:divide-slate-700/80 dark:bg-slate-800/70">
            @forelse($academicYears as $academicYear)
                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/30">
                    <td class="px-4 py-2 text-center">{{ $academicYear->id }}</td>
                    <td class="px-4 py-2 text-center font-medium text-slate-900 dark:text-white">{{ $academicYear->name }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $academicYear->semester === 'bahorgi' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300' }}">
                            {{ $academicYear->semester === 'bahorgi' ? __('messages.spring_semester') : __('messages.fall_semester') }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        @if($academicYear->is_active)
                            <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-800 dark:bg-indigo-500/15 dark:text-indigo-300">{{ __('messages.active') }}</span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center">{{ $academicYear->created_at ? $academicYear->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('admin.academic-years.edit', $academicYear->id) }}" class="rounded bg-blue-600 px-4 py-1 font-semibold text-white hover:bg-blue-700">
                            {{ __('messages.edit') }}
                        </a>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <form method="POST" action="{{ secure_route('admin.academic-years.destroy', $academicYear->id) }}" style="display:inline-block" onsubmit="return confirm(@js(__('messages.delete_academic_year_confirm')))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded bg-red-600 px-4 py-1 font-semibold text-white hover:bg-red-700">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-6 text-center text-slate-500 dark:text-slate-400">{{ __('messages.no_academic_years') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
