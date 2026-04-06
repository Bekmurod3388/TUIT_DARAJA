@extends('admin.layout')
@section('title', __('messages.users'))

@section('content')
<div class="rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-4 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.users') }}</h1>
    <div class="overflow-x-auto rounded-xl border border-slate-200/70 dark:border-slate-700">
        <table class="min-w-full text-sm text-slate-700 dark:text-slate-200">
            <thead class="bg-slate-50/90 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-900/70 dark:text-slate-400">
                <tr>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">#</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.avatar') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.full_name') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.phone_number') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">OneID</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.role') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.created_at_label') }}</th>
                    <th class="border-b border-slate-200 px-4 py-3 text-center dark:border-slate-700">{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200/80 bg-white/70 dark:divide-slate-700/80 dark:bg-slate-800/70">
                @forelse($users as $user)
                    <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/30">
                        <td class="px-4 py-2 text-center">{{ $user->id }}</td>
                        <td class="px-4 py-2 text-center text-2xl">
                            @if($user->role === 'admin' || $user->role === 'superadmin')
                                🛡️
                            @else
                                🧑‍💼
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center text-slate-900 dark:text-white">{{ $user->last_name }} {{ $user->first_name }} {{ $user->middle_name }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->phone }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->oneid_id ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->role ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">{{ __('messages.edit') }}</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm(@js(__('messages.delete_user_confirm')))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">{{ __('messages.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 text-center text-slate-500 dark:text-slate-400">{{ __('messages.no_users') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
