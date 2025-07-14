<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Foydalanuvchilar</title>
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
            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($user->name ?? 'Admin') }}" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-blue-400 shadow">
        </div>
        <div class="text-center mb-8">
            <div class="font-bold text-lg text-gray-800">{{ strtoupper($user->name ?? 'Admin') }}</div>
            <div class="text-xs text-gray-500 mt-1">Admin panel</div>
        </div>
        <nav class="w-full px-6">
            <ul class="space-y-2">
                <li>
                    <a href="/admin" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="flex items-center px-4 py-2 rounded-lg bg-blue-100 text-blue-700 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Foydalanuvchilar
                    </a>
                </li>
                <li>
                    <a href="/admin/programs" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                        </svg>
                        Dasturlar
                    </a>
                </li>
                <li>
                    <a href="/admin/applications" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Arizalar
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
            <h1 class="text-2xl font-bold mb-4">Foydalanuvchilar</h1>
            <div class="overflow-x-auto">
                <table class="min-w-full border rounded">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-center">#</th>
                            <th class="px-4 py-2 text-center">F.I.O.</th>
                            <th class="px-4 py-2 text-center">Telefon raqami</th>
                            <th class="px-4 py-2 text-center">OneID</th>
                            <th class="px-4 py-2 text-center">Roli</th>
                            <th class="px-4 py-2 text-center">Amal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-2 text-center">{{ $user->id }}</td>
                                <td class="px-4 py-2 text-center">{{ $user->last_name }} {{ $user->first_name }} {{ $user->middle_name }}</td>
                                <td class="px-4 py-2 text-center">{{ $user->phone }}</td>
                                <td class="px-4 py-2 text-center">{{ $user->oneid_id ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">{{ $user->role ?? '-' }}</td>
                                <td class="px-4 py-2 text-center flex gap-2 justify-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Tahrirlash</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Foydalanuvchini o‘chirishga ishonchingiz komilmi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded font-semibold">O‘chirish</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">Foydalanuvchilar mavjud emas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html> 