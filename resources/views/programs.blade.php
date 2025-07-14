<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasturlar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col items-center py-8">
        <div class="mb-6">
            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($user->name ?? 'User') }}" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-amber-400 shadow">
        </div>
        <div class="text-center mb-8">
            <div class="font-bold text-lg text-gray-800">{{ strtoupper($user->name ?? 'Foydalanuvchi') }}</div>
            <div class="text-xs text-gray-500 mt-1">EGOV ID foydalanuvchisi</div>
        </div>
        <nav class="w-full px-6">
            <ul class="space-y-2">
                <li>
                    <a href="/my-applications" class="flex items-center px-4 py-2 rounded-lg {{ request()->is('my-applications') ? 'bg-amber-100 text-amber-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                        </svg>
                        Mening arizalarim
                    </a>
                </li>
                <li>
                    <a href="/programs" class="flex items-center px-4 py-2 rounded-lg {{ request()->is('programs') ? 'bg-amber-100 text-amber-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h6" />
                        </svg>
                        Dasturlar
                    </a>
                </li>
            </ul>
        </nav>
        <div class="mt-auto w-full px-6">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center mt-8 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8">
            <h1 class="text-2xl font-bold mb-2">Dasturlar</h1>
            <div class="mb-4 text-gray-600">Hozircha hech qanday dastur yo‘q.</div>
            <div class="overflow-x-auto">
                <table class="min-w-full border rounded">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-center">#</th>
                            <th class="px-4 py-2 text-center">Nomi</th>
                            <th class="px-4 py-2 text-center">Raqami</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($programs as $program)
                        <tr>
                            <td class="px-4 py-2 text-center">{{ $program->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $program->name }}</td>
                            <td class="px-4 py-2 text-center">{{ $program->number }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">Dasturlar topilmadi</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-xs text-gray-400 text-right">
                Malakaviy imtihon © {{ date('Y') }}
            </div>
        </div>
    </main>
</div>
</body>
</html> 