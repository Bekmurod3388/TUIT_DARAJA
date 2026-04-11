@extends('admin.layout')
@section('title', __('messages.edit_program'))

@section('content')
<div class="mx-auto max-w-lg rounded-2xl border border-slate-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-slate-700 dark:bg-slate-800/90">
    <h1 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ __('messages.edit_program') }}</h1>
    <form method="POST" action="{{ secure_route('admin.programs.update', $program->id) }}">
        @csrf
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.academic_year') }}</label>
            <select name="academic_year_id" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required>
                <option value="">{{ __('messages.select') }}</option>
                @foreach($academicYears as $academicYear)
                    <option value="{{ $academicYear->id }}" @selected(old('academic_year_id', $program->academic_year_id) == $academicYear->id)>
                        {{ $academicYear->name }} - {{ $academicYear->semester === 'bahorgi' ? __('messages.spring_semester') : __('messages.fall_semester') }}{{ $academicYear->is_active ? ' (' . __('messages.active') . ')' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.program_name') }}</label>
            <select id="program-name-select" name="program_name_id" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" required>
                <option value="">{{ __('messages.select') }}</option>
                @foreach($programNames as $programName)
                    <option value="{{ $programName->id }}" data-code="{{ $programName->code }}" data-name="{{ $programName->name }}" {{ $program->program_name_id == $programName->id ? 'selected' : '' }}>
                        {{ $programName->code }} - {{ $programName->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.program_code') }}</label>
            <input type="text" id="program-code" class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2 text-slate-700 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200" readonly value="{{ $program->code }}">
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.subjects') }}</label>
            <select name="subjects[]" id="subjects-select" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" multiple required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->fan_id ?? $subject->id }}" {{ in_array($subject->fan_id ?? $subject->id, $selectedSubjects ?? []) ? 'selected' : '' }}>{{ $subject->fan ?? $subject->name }}</option>
                @endforeach
            </select>
            <small class="text-slate-500 dark:text-slate-400">{{ __('messages.select_subjects_hint') }}</small>
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.payment_amount_soum') }}</label>
            <input type="number" name="price" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" min="0" required value="{{ old('price', $program->price) }}">
        </div>
        <div class="mb-4">
            <label class="mb-1 block font-semibold text-slate-900 dark:text-white">{{ __('messages.short_description') }}</label>
            <textarea name="description" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" rows="3" required>{{ $program->description }}</textarea>
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" id="is_visible" name="is_visible" value="1" class="mr-2" {{ $program->is_visible ? 'checked' : '' }}>
            <label for="is_visible" class="font-semibold text-slate-900 dark:text-white">{{ __('messages.visible_to_users') }}</label>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">{{ __('messages.save_changes') }}</button>
        <a href="{{ route('admin.programs') }}" class="ml-4 text-slate-600 hover:underline dark:text-slate-400">{{ __('messages.cancel') }}</a>
    </form>
    <style>
        .dark .select2-container--default .select2-selection--multiple,
        .dark .select2-container--default .select2-selection--single,
        .dark .select2-dropdown {
            background-color: rgb(30 41 59);
            border-color: rgb(71 85 105);
            color: rgb(226 232 240);
        }
        .dark .select2-results__option,
        .dark .select2-search__field,
        .dark .select2-selection__rendered {
            color: rgb(226 232 240);
        }
        .dark .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: rgb(37 99 235);
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(30 64 175);
            border-color: rgb(59 130 246);
            color: rgb(219 234 254);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('#subjects-select').select2({
                width: '100%',
                placeholder: @json(__('messages.select_subjects_placeholder')),
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
