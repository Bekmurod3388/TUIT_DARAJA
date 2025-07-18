@extends('admin.layout')
@section('title', 'Foydalanuvchilar')
@section('content')
<div class="bg-white rounded-xl shadow p-8">
    <h1 class="text-2xl font-bold mb-4">Foydalanuvchilar</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full border rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-center">#</th>
                    <th class="px-4 py-2 text-center">Avatar</th>
                    <th class="px-4 py-2 text-center">F.I.O.</th>
                    <th class="px-4 py-2 text-center">Telefon raqami</th>
                    <th class="px-4 py-2 text-center">OneID</th>
                    <th class="px-4 py-2 text-center">Roli</th>
                    <th class="px-4 py-2 text-center">Yaratilgan vaqt</th>
                    <th class="px-4 py-2 text-center">Amal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $user->id }}</td>
                        <td class="px-4 py-2 text-center text-2xl">
                            @if($user->role === 'admin' || $user->role === 'superadmin')
                                🛡️
                            @else
                                🧑‍💼
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">{{ $user->last_name }} {{ $user->first_name }} {{ $user->middle_name }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->phone }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->oneid_id ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->role ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}</td>
                        <td class="px-4 py-2 text-center flex gap-2 justify-center">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Tahrirlash</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Foydalanuvchini o‘chirishga ishonchingiz komilmi?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">O‘chirish</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Foydalanuvchilar mavjud emas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 