<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — {{ __('messages.app_name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <h1 class="text-8xl font-bold text-indigo-600">@yield('code')</h1>
        <p class="text-2xl font-semibold text-gray-800 mt-4">@yield('message')</p>
        <p class="text-gray-500 mt-2">@yield('description')</p>
        <a href="{{ url('/') }}"
           class="inline-block mt-8 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            {{ __('messages.go_home') }}
        </a>
    </div>
</body>
</html>
