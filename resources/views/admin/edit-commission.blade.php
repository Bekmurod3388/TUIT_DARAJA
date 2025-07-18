<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komissiyani tahrirlash</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8 max-w-lg mx-auto">
            <h1 class="text-2xl font-bold mb-6">Komissiyani tahrirlash</h1>
            <form method="POST" action="{{ route('admin.commissions.update', $commission->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Komissiya raisi</label>
                    <input type="text" name="chairman" class="w-full border rounded px-3 py-2" required value="{{ old('chairman', $commission->chairman) }}">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Rais o‘rinbosar</label>
                    <input type="text" name="deputy" class="w-full border rounded px-3 py-2" required value="{{ old('deputy', $commission->deputy) }}">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Komissiya kotibi</label>
                    <input type="text" name="secretary" class="w-full border rounded px-3 py-2" required value="{{ old('secretary', $commission->secretary) }}">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Dastur</label>
                    <select name="specalization_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Dastur tanlang</option>
                        @foreach($specalizations as $spec)
                            <option value="{{ $spec->id }}" {{ old('specalization_id', $commission->specalization_id) == $spec->id ? 'selected' : '' }}>{{ $spec->name }} ({{ $spec->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Komissiya a’zolari</label>
                    <textarea name="members" class="w-full border rounded px-3 py-2" rows="3" required>{{ old('members', $commission->members) }}</textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Saqlash</button>
                <a href="{{ route('admin.commissions') }}" class="ml-4 text-gray-600 hover:underline">Bekor qilish</a>
            </form>
        </div>
    </main>
</div>
</body>
</html> 