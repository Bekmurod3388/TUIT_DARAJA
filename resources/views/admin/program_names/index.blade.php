@extends('admin.layout')
@section('title', 'Dastur nomlari')
@section('content')
<div class="bg-white rounded-xl shadow p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dastur nomlari</h1>
        <a href="{{ route('admin.program-names.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Yangi nom qo‘shish</a>
    </div>
    <table class="min-w-full border rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-center">#</th>
                <th class="px-4 py-2 text-center">Nom</th>
                <th class="px-4 py-2 text-center">Dastur kodi</th>
                <th class="px-4 py-2 text-center">Yaratilgan vaqt</th>
                <th class="px-4 py-2 text-center">Tahrirlash</th>
                <th class="px-4 py-2 text-center">O‘chirish</th>
            </tr>
        </thead>
        <tbody>
        @forelse($programNames as $programName)
            <tr>
                <td class="px-4 py-2 text-center">{{ $programName->id }}</td>
                <td class="px-4 py-2 text-center">{{ $programName->name }}</td>
                <td class="px-4 py-2 text-center">{{ $programName->code }}</td>
                <td class="px-4 py-2 text-center">{{ $programName->created_at ? $programName->created_at->format('Y-m-d H:i') : '-' }}</td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('admin.program-names.edit', $programName->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Tahrirlash</a>
                </td>
                <td class="px-4 py-2 text-center">
                    <form method="POST" action="{{ route('admin.program-names.destroy', $programName->id) }}" style="display:inline-block" onsubmit="return confirm('Nom o‘chirilsinmi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">O‘chirish</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-4">Nomlar yo‘q</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection 