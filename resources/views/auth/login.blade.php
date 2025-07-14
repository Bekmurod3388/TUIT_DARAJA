<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish - TUIT DARAJA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: #d97706;
            color: white;
            border: none;
        }
        .btn-primary:hover {
            background-color: #b45309;
        }
        .btn-egov {
            background-color: #2563eb;
            color: white;
            border: none;
        }
        .btn-egov:hover {
            background-color: #1d4ed8;
        }
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-top: 0.25rem;
        }
        .form-input:focus {
            outline: none;
            border-color: #d97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
            <!-- Logo va sarlavha -->
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-amber-500 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">TUIT DARAJA</h2>
                <p class="mt-2 text-sm text-gray-600">Tizimga kirish</p>
            </div>

            <!-- Xatolik xabarlari -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefon raqamingiz</label>
                    <input id="phone" name="phone" type="text" autocomplete="tel" required class="form-input mt-1 block w-full" placeholder="+998 (__) ___-__-__" value="{{ old('phone') }}" maxlength="19">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Parol</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="form-input mt-1 block w-full" placeholder="Parol kiriting">
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Eslab qolish</label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary w-full">Kirish</button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-amber-700 hover:underline">Ro‘yxatdan o‘tish</a>
            </div>
        </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    EGOV ID orqali kirish uchun <a href="https://id.egov.uz" target="_blank" class="text-amber-600 hover:text-amber-500">id.egov.uz</a> da ro'yxatdan o'ting
                </p>
            </div>
        </div>
    </div>
</body>
<script>
// Telefon raqami uchun input mask
const phoneInput = document.getElementById('phone');
if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
        let x = this.value.replace(/\D/g, '').replace(/^998/, '');
        if (x.length > 9) x = x.slice(0, 9);
        let formatted = '+998 ';
        if (x.length > 0) formatted += '(' + x.substring(0,2);
        if (x.length >= 2) formatted += ') ' + x.substring(2,5);
        if (x.length >= 5) formatted += '-' + x.substring(5,7);
        if (x.length >= 7) formatted += '-' + x.substring(7,9);
        this.value = formatted.trim();
    });
    phoneInput.addEventListener('focus', function() {
        if (!this.value) this.value = '+998 ';
    });
}
</script>
</html> 