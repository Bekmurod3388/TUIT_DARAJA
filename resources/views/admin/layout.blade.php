<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('head')
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-4 md:p-10">
        @include('admin.partials.alerts')
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html> 