@extends('admin.layout')
@section('title', 'Arizalar')
@section('content')
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
                <th class="px-4 py-3 text-center whitespace-nowrap">Yaratilgan vaqt</th>
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
                <td class="px-4 py-3 text-center">
                    @if($app->is_scored)
                        <span class="inline-block bg-green-100 text-green-800 rounded px-2 py-1 text-xs font-semibold">Ball: {{ $app->score }}</span>
                    @else
                        <form method="POST" action="{{ route('admin.applications.setScore', $app->id) }}" class="flex items-center gap-2 justify-center">
                            @csrf
                            <input type="number" name="score" min="0" max="100" class="w-20 border rounded px-2 py-1 text-center" placeholder="Ball" required>
                            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-1 rounded font-semibold">Qo‘yish</button>
                        </form>
                    @endif
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
                <td class="px-4 py-3 text-center">{{ $app->created_at ? $app->created_at->format('Y-m-d H:i') : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="15" class="text-center text-gray-500 py-4">Arizalar yo‘q</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection 