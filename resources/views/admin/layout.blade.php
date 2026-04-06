<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.admin_panel')) - {{ __('messages.app_name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-script')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.3); 
        }
        .dark .glass-panel {
            background: rgba(30, 41, 59, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; }
    </style>
    @stack('head')
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 selection:bg-indigo-500 selection:text-white flex overflow-hidden dark:bg-slate-900 transition-colors duration-300 dark:text-slate-300">
    
    <!-- Abstract Decoration -->
    <div class="fixed top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] rounded-full bg-indigo-500/5 blur-3xl pointer-events-none z-0"></div>

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden transition-opacity lg:hidden dark:bg-slate-900/80" onclick="toggleSidebar()"></div>

    @include('admin.sidebar')
    
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-10">
        <!-- Top Navbar for Mobile -->
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 h-16 flex items-center justify-between px-4 lg:hidden z-20 dark:bg-slate-900/80 dark:border-slate-800">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="p-2 mr-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none dark:text-slate-400 dark:hover:bg-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <span class="font-bold text-lg text-slate-800 dark:text-white">{{ __('messages.app_name') }}</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200 dark:bg-indigo-900/50 dark:border-indigo-700 dark:text-indigo-400">A</div>
        </header>

        <!-- Main Content Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-transparent p-4 md:p-8 lg:p-10 custom-scrollbar">
            <div class="max-w-7xl mx-auto">
                @include('admin.partials.alerts')
                @yield('content')
            </div>
        </main>
    </div>

    @include('components.theme-toggle-scripts')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
