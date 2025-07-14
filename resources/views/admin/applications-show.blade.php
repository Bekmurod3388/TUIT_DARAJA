<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ariza batafsil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Ariza batafsil</h1>
            <div class="space-y-4 text-lg">
                <div><span class="font-semibold">F.I.O.:</span> {{ $application->last_name }} {{ $application->first_name }} {{ $application->middle_name }}</div>
                <div><span class="font-semibold">Telefon raqami:</span> {{ $application->phone }}</div>
                <div><span class="font-semibold">Ixtisoslik:</span> {{ $application->specalization->name ?? '-' }}</div>
                <div><span class="font-semibold">Tashkilot:</span> {{ $application->organization }}</div>
                <div><span class="font-semibold">Fan nomi:</span> {{ $application->subject }}</div>
                <div><span class="font-semibold">Ta'lim turi:</span> {{ $application->education_type }}</div>
                <div><span class="font-semibold">Status:</span> @php
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
                    $status = $application->status;
                @endphp
                <span class="font-semibold px-3 py-2 rounded text-base {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusUz[$status] ?? 'Jarayonda' }}
                </span>
                </div>
                <div><span class="font-semibold">OAC fayli:</span> @if($application->oac_file)<a href="/{{ $application->oac_file }}" target="_blank" class="text-blue-600 underline">Yuklab olish</a>@else-@endif</div>
                <div><span class="font-semibold">Yo'llanma fayli:</span> @if($application->direction_file)<a href="/{{ $application->direction_file }}" target="_blank" class="text-blue-600 underline">Yuklab olish</a>@else-@endif</div>
                <div><span class="font-semibold">To'lov cheki:</span> @if($application->receipt_file)<a href="/{{ $application->receipt_file }}" target="_blank" class="text-blue-600 underline">Yuklab olish</a>@else-@endif</div>
                <div><span class="font-semibold">Ish buyrug'i:</span> @if($application->work_order_file)<a href="/{{ $application->work_order_file }}" target="_blank" class="text-blue-600 underline">Yuklab olish</a>@else-@endif</div>
            </div>
            <div class="mt-8">
                <a href="{{ route('admin.applications') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded font-semibold">Ortga</a>
            </div>
        </div>
    </main>
</div>
</body>
</html> 