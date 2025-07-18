@extends('admin.sidebar')
@section('content')
<div class="container mx-auto py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Dastur nomini tahrirlash</h1>
    <form action="{{ route('admin.program-names.update', $programName) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Dastur nomi</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full" value="{{ old('name', $programName->name) }}" required maxlength="255">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.program-names.index') }}" class="text-gray-600 hover:underline">Orqaga</a>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded">Saqlash</button>
        </div>
    </form>
</div>
@endsection 