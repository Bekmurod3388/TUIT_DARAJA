@extends('admin.layout')
@section('title', 'Yangi dastur qo‘shish')
@section('content')
<div class="bg-white rounded-xl shadow p-8 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6">Yangi dastur qo‘shish</h1>
    @if ($errors->any())
        <div class="mb-4">
            <div class="text-red-600 font-semibold">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.programs.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Fanlar</label>
            <select name="subjects[]" id="subjects-select" class="w-full border rounded px-3 py-2" multiple required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->fan_id }}">{{ $subject->fan }}</option>
                @endforeach
            </select>
            <small class="text-gray-500">Bir nechta fan tanlash uchun Ctrl (yoki Cmd) tugmasini bosing.</small>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Dastur nomi</label>
            <select id="program-name-select" name="program_name_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Tanlang...</option>
                @foreach($programNames as $programName)
                    <option value="{{ $programName->id }}" data-code="{{ $programName->code }}" data-name="{{ $programName->name }}">
                        {{ $programName->code }} - {{ $programName->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Dastur kodi</label>
            <input type="text" id="program-code" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">To'lov summasi (so'mda)</label>
            <input type="number" name="price" class="w-full border rounded px-3 py-2" min="0" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Qisqacha ma'lumot</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Saqlash</button>
        <a href="{{ route('admin.programs') }}" class="ml-4 text-gray-600 hover:underline">Bekor qilish</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('#subjects-select').select2({
                width: '100%',
                placeholder: 'Fanlarni tanlang',
                allowClear: true
            });
            $('#program-name-select').on('change', function() {
                var code = $(this).find('option:selected').data('code') || '';
                $('#program-code').val(code);
            });
        });
    </script>
</div>
@endsection 