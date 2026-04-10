@extends('admin.layout')
@section('title', __('messages.edit_program_name'))

@section('content')
<div class="container mx-auto py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">{{ __('messages.edit_program_name') }}</h1>
    <form action="{{ secure_route('admin.program-names.update', $programName) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.program_name') }}</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full" value="{{ old('name', $programName->name) }}" required maxlength="255">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">{{ __('messages.program_code') }}</label>
            <input type="text" name="code" id="code" class="form-input mt-1 block w-full" value="{{ old('code', $programName->code) }}" required maxlength="255">
            @error('code')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.program-names.index') }}" class="text-gray-600 hover:underline">{{ __('messages.back') }}</a>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded">{{ __('messages.save_changes') }}</button>
        </div>
    </form>
</div>
@endsection
