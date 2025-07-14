<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Arizalar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10 md:pr-8 pr-2">
        <div class="bg-white rounded-xl shadow p-4 overflow-x-auto">
            <h1 class="text-xl font-bold mb-4">Arizalar</h1>
            <table class="w-full border rounded text-base table-auto">
                <thead class="sticky top-0 z-10 bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-center whitespace-nowrap">F.I.O.</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Telefon raqami</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Ixtisoslik</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Batafsil</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Amal</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td class="px-4 py-3 text-center font-medium">{{ $app->last_name }} {{ $app->first_name }} {{ $app->middle_name }}</td>
                        <td class="px-4 py-3 text-center">{{ $app->phone }}</td>
                        <td class="px-4 py-3 text-center">{{ $app->specalization->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">Batafsil</a>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusUz = [
                                    'pending' => 'Jarayonda',
                                    'accepted' => 'Qabul qilindi',
                                    'cancelled' => 'Bekor qilindi',
                                ];
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'accepted' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $status = $app->status;
                            @endphp
                            <span class="font-semibold px-6 py-3 rounded text-base min-w-[120px] text-center inline-block {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusUz[$status] ?? 'Jarayonda' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center flex gap-2 justify-center">
                            <form method="POST" action="{{ route('admin.applications.updateStatus', $app->id) }}">
                                @csrf
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-base font-semibold" @if($app->status=='accepted') disabled @endif>Qabul</button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.updateStatus', $app->id) }}">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-base font-semibold" @if($app->status=='cancelled') disabled @endif>Bekor</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center text-gray-500 py-4">Arizalar yo‘q</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html> 