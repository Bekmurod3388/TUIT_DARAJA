@extends('admin.layout')
@section('title', 'Dasturlar')
@section('content')
<div class="bg-white rounded-xl shadow p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dasturlar</h1>
        <a href="{{ route('admin.programs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Yangi dastur qo‘shish</a>
    </div>
    <table class="min-w-full border rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-center">#</th>
                <th class="px-4 py-2 text-center">Dastur nomi</th>
                <th class="px-4 py-2 text-center">Dastur kodi</th>
                <th class="px-4 py-2 text-center">To'lov summasi (so'mda)</th>
                <th class="px-4 py-2 text-center">Fanlar</th>
                <th class="px-4 py-2 text-center">Yaratilgan vaqt</th>
                <th class="px-4 py-2 text-center">Ko‘rsatish</th>
                <th class="px-4 py-2 text-center">Tahrirlash</th>
                <th class="px-4 py-2 text-center">O‘chirish</th>
            </tr>
        </thead>
        <tbody>
        @forelse($programs as $program)
            <tr>
                <td class="px-4 py-2 text-center">{{ $program->id }}</td>
                <td class="px-4 py-2 text-center">{{ $program->name }}</td>
                <td class="px-4 py-2 text-center">{{ $program->code }}</td>
                <td class="px-4 py-2 text-center">{{ number_format($program->price, 0, ",", " ") }}</td>
                <td class="px-4 py-2 text-center">
                    @foreach($program->subjects as $subject)
                        <span class="inline-block bg-blue-100 text-blue-800 rounded px-2 py-1 text-xs font-semibold mr-1 mb-1">{{ $subject->fan }}</span>
                    @endforeach
                </td>
                <td class="px-4 py-2 text-center">{{ $program->created_at ? $program->created_at->format('Y-m-d H:i') : '-' }}</td>
                <td class="px-4 py-2 text-center">
                    <form method="POST" action="{{ route('admin.programs.update', $program->id) }}" style="display:inline-block">
                        @csrf
                        <input type="hidden" name="is_visible" value="{{ $program->is_visible ? 0 : 1 }}">
                        <button type="submit" class="px-3 py-1 rounded font-semibold {{ $program->is_visible ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-700' }}">
                            {{ $program->is_visible ? 'Ko‘rsatilmoqda' : 'Yashirilgan' }}
                        </button>
                    </form>
                </td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('admin.programs.edit', $program->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Tahrirlash</a>
                </td>
                <td class="px-4 py-2 text-center">
                    <form method="POST" action="{{ route('admin.programs.destroy', $program->id) }}" style="display:inline-block" onsubmit="return confirm('Dastur o‘chirilsinmi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">O‘chirish</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-gray-500 py-4">Dasturlar yo‘q</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection 