<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dasturlar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Dasturlar</h1>
                <a href="{{ route('admin.programs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Yangi dastur qo‘shish</a>
            </div>
            <table class="min-w-full border rounded">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-center">#</th>
                        <th class="px-4 py-2 text-center">Shifri</th>
                        <th class="px-4 py-2 text-center">Nomi</th>
                        <th class="px-4 py-2 text-center">Qisqacha ma'lumot</th>
                        <th class="px-4 py-2 text-center">Foydalanuvchilarga ko‘rsatish</th>
                        <th class="px-4 py-2 text-center">Tahrirlash</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($programs as $program)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $program->id }}</td>
                        <td class="px-4 py-2 text-center">{{ $program->code }}</td>
                        <td class="px-4 py-2 text-center">{{ $program->name }}</td>
                        <td class="px-4 py-2 text-center">{{ $program->description }}</td>
                        <td class="px-4 py-2 text-center">
                            <form method="POST" action="{{ route('admin.programs.update', $program->id) }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="code" value="{{ $program->code }}">
                                <input type="hidden" name="name" value="{{ $program->name }}">
                                <input type="hidden" name="description" value="{{ $program->description }}">
                                <input type="hidden" name="is_visible" value="{{ $program->is_visible ? 0 : 1 }}">
                                <button type="submit" class="focus:outline-none" title="{{ $program->is_visible ? 'Foydalanuvchilarga ko‘rsatishni o‘chirish' : 'Foydalanuvchilarga ko‘rsatishni yoqish' }}">
                                    @if($program->is_visible)
                                        <!-- Green modern eye icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 hover:text-green-800 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    @else
                                        <!-- Red ban/forbidden icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                                            <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" />
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.programs.edit', $program->id) }}" class="text-blue-600 hover:underline">Tahrirlash</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Dasturlar yo‘q</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html> 