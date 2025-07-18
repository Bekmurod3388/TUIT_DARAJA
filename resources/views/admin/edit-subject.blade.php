<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Fan tahrirlash</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8 max-w-lg mx-auto">
            <h1 class="text-2xl font-bold mb-6">Fan tahrirlash</h1>
            <form method="POST" action="{{ route('admin.subjects.update', $subject->fan_id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Fan nomi</label>
                    <input type="text" name="fan" class="w-full border rounded px-3 py-2" required value="{{ old('fan', $subject->fan) }}">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Saqlash</button>
                <a href="{{ route('admin.subjects') }}" class="ml-4 text-gray-600 hover:underline">Bekor qilish</a>
            </form>
        </div>
    </main>
</div>
</body>
</html> 