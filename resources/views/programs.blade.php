<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.programs') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-script')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden selection:bg-indigo-500 selection:text-white dark:bg-slate-900 transition-colors duration-300">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden transition-opacity md:hidden dark:bg-slate-900/80" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="mainSidebar" class="w-72 bg-white border-r border-slate-200 flex flex-col justify-between py-8 px-6 shadow-sm absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-300 ease-in-out z-50 dark:bg-slate-800 dark:border-slate-700">
        <div>
            <!-- User Profile Card -->
            <div class="flex flex-col items-center mb-10 text-center relative">
                <button onclick="toggleSidebar()" class="md:hidden absolute -top-4 -right-2 p-2 bg-slate-100 rounded-full text-slate-500 hover:text-slate-800 focus:outline-none transition-colors dark:bg-slate-700 dark:text-slate-400 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                @php
                    $fullName = trim(($user->last_name ?? '').' '.($user->first_name ?? '').' '.($user->middle_name ?? ''));
                    $displayName = $fullName ?: 'Foydalanuvchi';
                    $initials = mb_substr(trim($user->first_name ?? 'F'), 0, 1) . mb_substr(trim($user->last_name ?? 'U'), 0, 1);
                @endphp
                <div class="relative w-24 h-24 mb-4 rounded-full p-1 bg-gradient-to-tr from-indigo-500 to-purple-500 shadow-md">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($initials) }}&background=ffffff&color=4f46e5&size=150&bold=true" alt="Avatar" class="w-full h-full object-cover rounded-full border-2 border-white dark:border-slate-800">
                </div>
                <h2 class="font-bold text-slate-800 text-lg leading-tight dark:text-white">{{ $displayName }}</h2>
                <span class="text-xs font-medium text-slate-500 mt-1 bg-slate-100 px-3 py-1 rounded-full dark:bg-slate-700 dark:text-slate-300">{{ __('messages.user_egov') }}</span>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('my.applications') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('my-applications') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('my-applications') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('messages.my_applications') }}
                </a>
                <a href="{{ route('programs') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->is('programs') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->is('programs') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    {{ __('messages.programs') }}
                </a>
            </nav>
        </div>

        <div class="space-y-4">
            <div class="flex justify-center border-t border-slate-200 dark:border-slate-700 pt-4">
                @include('components.navbar-toggles')
            </div>
            <form method="POST" action="{{ secure_route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-red-600 hover:border-red-200 rounded-xl font-medium transition-all duration-200 shadow-sm dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-red-500/10 dark:hover:text-red-400 dark:hover:border-red-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    {{ __('messages.logout') }}
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative z-10 w-full">
        <!-- Top Navbar for Mobile -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200 h-16 flex items-center justify-between px-4 md:hidden z-20 shrink-0 shadow-sm dark:bg-slate-900/90 dark:border-slate-800">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="p-2 mr-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none transition-colors dark:text-slate-400 dark:hover:bg-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <span class="font-bold text-lg text-slate-800 dark:text-white">{{ __('messages.app_name') }}</span>
            </div>
            @php $menuInitials = mb_substr(trim($user->first_name ?? 'F'), 0, 1) . mb_substr(trim($user->last_name ?? 'U'), 0, 1); @endphp
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200 text-xs dark:bg-indigo-900/50 dark:text-indigo-300 dark:border-indigo-700">{{ $menuInitials }}</div>
        </header>

        <!-- Main Content Scrollable Area -->
        <main class="flex-1 p-4 md:p-10 lg:p-12 overflow-x-hidden overflow-y-auto custom-scrollbar relative w-full">
            <!-- Abstract Decoration -->
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none z-0 dark:bg-indigo-500/5"></div>
        
        <div class="max-w-6xl mx-auto relative z-10" data-aos="fade-in">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-6 border-b border-slate-200 dark:border-slate-800">
                <div data-aos="fade-right">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight dark:text-white">{{ __('messages.programs') }}</h1>
                    <p class="text-slate-500 mt-2 font-medium dark:text-slate-400">{{ __('messages.all_programs') }}</p>
                    @if($programs->isNotEmpty() && $programs->first()?->academicYear)
                        <p class="mt-1 text-xs font-medium text-indigo-600 dark:text-indigo-400">
                            {{ __('messages.active_academic_year_label') }}: {{ $programs->first()->academicYear->name }} - {{ $programs->first()->academicYear->semester === 'bahorgi' ? __('messages.spring_semester') : __('messages.fall_semester') }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Desktop Data Table -->
            <div class="hidden md:block w-full overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md dark:border-slate-700 dark:bg-slate-800/90" data-aos="fade-up" data-aos-delay="100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600 dark:bg-transparent dark:text-slate-300">
                        <thead class="border-b border-slate-200 bg-slate-50/90 text-xs uppercase text-slate-500 dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold text-center w-16">#</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-left">{{ __('messages.subjects') }}</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-left">{{ __('messages.name') }}</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">{{ __('messages.code') }}</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">{{ __('messages.payment_amount') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white/70 dark:divide-slate-700 dark:bg-slate-800/70">
                        @forelse($programs as $program)
                            <tr class="group bg-transparent transition-colors duration-150 hover:bg-slate-50 dark:hover:bg-slate-700/40">
                                <td class="px-6 py-4 text-center font-medium text-slate-900 dark:text-white">
                                    {{ $program->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if($program->subjects && count($program->subjects))
                                            @foreach($program->subjects as $subject)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">
                                                    {{ $subject->fan ?? $subject->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-slate-400 font-medium dark:text-slate-500">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 leading-tight dark:text-white">{{ $program->name }}</div>
                                    <div class="text-xs text-slate-400 mt-1 dark:text-slate-500">{{ $program->created_at ? $program->created_at->format('Y-m-d') : '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-mono text-slate-700 bg-slate-100 px-2.5 py-1 rounded-md text-xs font-bold border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">{{ $program->code }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-900 dark:text-white">
                                    {{ number_format($program->price, 0, ",", " ") }} <span class="text-xs text-slate-500 font-medium dark:text-slate-400">UZS</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/70">
                                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <p class="text-slate-500 font-medium dark:text-slate-400">{{ __('messages.no_programs') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Cards View -->
            <div class="md:hidden space-y-4" data-aos="fade-up" data-aos-delay="100">
                @forelse($programs as $program)
                    <div class="relative rounded-xl border border-slate-200 bg-white/95 p-4 shadow-sm transition-transform transform hover:-translate-y-1 dark:border-slate-700 dark:bg-slate-800/90">
                        <div class="absolute top-4 right-4 font-mono text-slate-700 bg-slate-100 px-2 py-0.5 rounded text-[10px] font-bold border border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600">{{ $program->code }}</div>
                        <h3 class="font-bold text-slate-900 text-base leading-tight pr-12 dark:text-white">{{ $program->name }}</h3>
                        <div class="text-xs text-slate-400 mt-1 mb-3 dark:text-slate-500">{{ $program->created_at ? $program->created_at->format('Y-m-d') : '' }}</div>
                        
                        <div class="mb-3">
                            <div class="text-xs text-slate-500 mb-1 dark:text-slate-400">{{ __('messages.subjects') }}:</div>
                            <div class="flex flex-wrap gap-1">
                                @if($program->subjects && count($program->subjects))
                                    @foreach($program->subjects as $subject)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">
                                            {{ $subject->fan ?? $subject->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-slate-400 font-medium text-xs dark:text-slate-500">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center dark:border-slate-700">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ __('messages.payment_amount') }}:</span>
                            <div class="font-bold text-slate-900 text-sm dark:text-white">
                                {{ number_format($program->price, 0, ",", " ") }} <span class="text-[10px] text-slate-500 dark:text-slate-400">UZS</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-slate-200 bg-white/95 p-8 text-center shadow-sm dark:border-slate-700 dark:bg-slate-800/90">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/70">
                            <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium text-sm dark:text-slate-400">{{ __('messages.no_programs') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-200 text-xs text-slate-400 text-right dark:border-slate-800 dark:text-slate-500">
                {{ __('messages.footer_rights') }} &copy; {{ date('Y') }}
            </div>
        </div>
        </div>
    </main>
</div>

@include('components.theme-toggle-scripts')
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('mainSidebar');
        const overlay = document.getElementById('mobileOverlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({ once: true, duration: 600, easing: 'ease-out' });
        }
    });
</script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>
