<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foydalanuvchini tahrirlash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8 max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Foydalanuvchini tahrirlash</h1>
            <form method="POST" action="{{ route('admin.users.update', $editUser->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-semibold mb-1">Familiya</label>
                    <input type="text" name="last_name" class="form-input w-full rounded-xl border-2 border-blue-400 bg-blue-50 focus:border-blue-500 focus:ring-blue-500 text-lg h-12 px-4" required value="{{ old('last_name', $editUser->last_name) }}">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Ism</label>
                    <input type="text" name="first_name" class="form-input w-full rounded-xl border-2 border-blue-400 bg-blue-50 focus:border-blue-500 focus:ring-blue-500 text-lg h-12 px-4" required value="{{ old('first_name', $editUser->first_name) }}">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Otasining ismi</label>
                    <input type="text" name="middle_name" class="form-input w-full rounded-xl border-2 border-blue-400 bg-blue-50 focus:border-blue-500 focus:ring-blue-500 text-lg h-12 px-4" required value="{{ old('middle_name', $editUser->middle_name) }}">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Telefon raqami</label>
                    <input type="text" name="phone" class="form-input w-full rounded-xl border-2 border-blue-400 bg-blue-50 focus:border-blue-500 focus:ring-blue-500 text-lg h-12 px-4" required value="{{ old('phone', $editUser->phone) }}">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Roli</label>
                    <input type="text" name="role" class="form-input w-full rounded-xl border-2 border-blue-400 bg-blue-50 focus:border-blue-500 focus:ring-blue-500 text-lg h-12 px-4" value="{{ old('role', $editUser->role) }}">
                </div>
                <div class="flex gap-4 mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">Saqlash</button>
                    <a href="{{ route('admin.users') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold text-lg px-10 py-3 rounded-xl shadow">Bekor qilish</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html> 