<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ro‘yxatdan o‘tish</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-10 border border-gray-200">
        <h2 class="text-3xl font-bold mb-6 text-center text-amber-700">Ro‘yxatdan o‘tish</h2>
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-base font-semibold mb-2">Familiya</label>
                <input type="text" name="last_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('last_name') }}">
            </div>
            <div>
                <label class="block text-base font-semibold mb-2">Ism</label>
                <input type="text" name="first_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('first_name') }}">
            </div>
            <div>
                <label class="block text-base font-semibold mb-2">Otasining ismi</label>
                <input type="text" name="middle_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('middle_name') }}">
            </div>
            <div>
                <label class="block text-base font-semibold mb-2">Telefon raqami</label>
                <input type="text" name="phone" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('phone') }}" placeholder="+998 XX XXX-XX-XX">
            </div>
            <div>
                <label class="block text-base font-semibold mb-2">Parol</label>
                <input type="password" name="password" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required>
            </div>
            <div>
                <label class="block text-base font-semibold mb-2">Parolni tasdiqlang</label>
                <input type="password" name="password_confirmation" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required>
            </div>
            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">Ro‘yxatdan o‘tish</button>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-amber-700 hover:underline">Tizimga kirish</a>
            </div>
        </form>
    </div>
</body>
</html> 