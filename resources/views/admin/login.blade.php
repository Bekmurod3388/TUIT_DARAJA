<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kirish - TUIT DARAJA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .login-container { max-width: 400px; margin: 0 auto; padding: 2rem; background: #fff; border-radius: 0.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #d97706; color: #fff; border: none; border-radius: 0.375rem; padding: 0.75rem 1.5rem; font-weight: 500; transition: background 0.2s; width: 100%; }
        .btn-primary:hover { background-color: #b45309; }
        .form-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; margin-top: 0.25rem; }
        .form-input:focus { outline: none; border-color: #d97706; box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1); }
        .error-message { color: #b91c1c; font-size: 0.95em; margin-top: 0.25rem; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <main class="login-container" aria-label="Admin login form">
        <!-- Logo and Title -->
        <header class="text-center mb-8">
            <div class="mx-auto h-12 w-12 bg-amber-500 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">TUIT DARAJA</h1>
            <p class="mt-2 text-sm text-gray-600">Admin paneliga kirish</p>
        </header>

        <!-- Error Messages -->
        @if ($errors->any())
            <section class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded" aria-live="assertive">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="error-message">{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        <!-- Admin Login Form -->
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6" autocomplete="off" aria-label="Admin login">
            @csrf
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Admin telefon raqami</label>
                <input id="phone" name="phone" type="text" inputmode="tel" autocomplete="tel" required class="form-input mt-1 block w-full" placeholder="+998 (__) ___-__-__" value="{{ old('phone') }}" maxlength="19" aria-describedby="phoneHelp">
                <span id="phoneHelp" class="sr-only">Telefon raqamingizni to‘liq kiriting</span>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Parol</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required class="form-input mt-1 block w-full" placeholder="Parol kiriting">
            </div>
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Eslab qolish</label>
            </div>
            <button type="submit" class="btn-primary">Admin Kirish</button>
        </form>

        <!-- Footer -->
        <footer class="mt-6 text-center">
            <p class="text-xs text-gray-500">Faqat administratorlar uchun</p>
        </footer>
    </main>
    <script>
    // Telefon raqami uchun input mask (client-side UX)
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
</body>
</html> 