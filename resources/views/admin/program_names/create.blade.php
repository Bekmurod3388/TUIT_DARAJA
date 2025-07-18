@extends('admin.layout')
@section('title', 'Yangi dastur nomi')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-xl shadow p-8 mt-8">
    <h1 class="text-2xl font-bold mb-6">Yangi dastur nomi qo‘shish</h1>
    <form action="{{ route('admin.program-names.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Dastur nomi</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:ring-amber-500 focus:border-amber-500" value="{{ old('name') }}" required maxlength="255" placeholder="Masalan: Dasturiy injiniring">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Dastur kodi</label>
            <input type="text" name="code" id="code" class="form-input mt-1 block w-full border-gray-300 rounded px-3 py-2 focus:ring-amber-500 focus:border-amber-500" value="{{ old('code') }}" required maxlength="255" placeholder="Masalan: DI-01">
            @error('code')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.program-names.index') }}" class="text-gray-600 hover:underline">Orqaga</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold shadow">Saqlash</button>
        </div>
    </form>
</div>
@endsection 