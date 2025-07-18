@extends('admin.layout')
@section('title', 'Komissiyalar')
@section('content')
<div class="bg-white rounded-xl shadow p-8">
    <h1 class="text-2xl font-bold mb-4">Komissiyalar</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full border rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-center">#</th>
                    <th class="px-4 py-2 text-center">Ixtisoslik</th>
                    <th class="px-4 py-2 text-center">Raisi</th>
                    <th class="px-4 py-2 text-center">O‘rinbosar</th>
                    <th class="px-4 py-2 text-center">Kotib</th>
                    <th class="px-4 py-2 text-center">A’zolar</th>
                    <th class="px-4 py-2 text-center">Yaratilgan vaqt</th>
                    <th class="px-4 py-2 text-center">Tahrirlash</th>
                    <th class="px-4 py-2 text-center">O‘chirish</th>
                </tr>
            </thead>
            <tbody>
            @forelse($commissions as $commission)
                <tr>
                    <td class="px-4 py-2 text-center">{{ $commission->id }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->specalization->name ?? '-' }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->chairman }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->deputy }}</td>
                    <td class="px-4 py-2 text-center">{{ $commission->secretary }}</td>
                    <td class="px-4 py-2 text-center">
                        @php
                            $members = json_decode($commission->members, true);
                        @endphp
                        @if(is_array($members))
                            @foreach($members as $member)
                                <span class="inline-block bg-blue-100 text-blue-800 rounded px-2 py-1 text-xs font-semibold mr-1 mb-1">{{ $member }}</span>
                            @endforeach
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center">{{ $commission->created_at ? $commission->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('admin.commissions.edit', $commission->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Tahrirlash</a>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <form method="POST" action="{{ route('admin.commissions.destroy', $commission->id) }}" onsubmit="return confirm('Komissiyani o‘chirishga ishonchingiz komilmi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">O‘chirish</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">Komissiyalar mavjud emas</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 