<aside id="adminSidebar" class="w-72 bg-white border-r border-slate-200 flex flex-col justify-between py-8 px-6 shadow-sm absolute inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition duration-300 ease-in-out z-50 dark:bg-slate-800 dark:border-slate-700">
    <div>
        <!-- Profile Card -->
        <div class="flex flex-col items-center mb-10 text-center">
            <div class="relative w-24 h-24 mb-4 rounded-full p-1 bg-gradient-to-tr from-indigo-500 to-purple-500 shadow-md">
                <img src="https://ui-avatars.com/api/?name=Admin&background=ffffff&color=4f46e5&size=150&bold=true" alt="{{ __('messages.admin_panel') }}" class="w-full h-full object-cover rounded-full border-2 border-white dark:border-slate-800">
            </div>
            <h2 class="font-bold text-slate-800 text-lg leading-tight dark:text-white">{{ __('messages.admin_panel') }}</h2>
            <span class="text-xs font-medium text-slate-500 mt-1 bg-slate-100 px-3 py-1 rounded-full dark:bg-slate-700 dark:text-slate-300">{{ __('messages.system_administrator') }}</span>
            
            <!-- Mobile Close Button -->
            <button onclick="toggleSidebar()" class="lg:hidden absolute top-4 right-4 p-2 bg-slate-100 rounded-full text-slate-500 hover:text-slate-800 dark:bg-slate-700 dark:text-slate-400 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1.5 custom-scrollbar overflow-y-auto max-h-[50vh] pr-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                {{ __('messages.dashboard') }}
            </a>
            
            <a href="{{ route('admin.subjects') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.subjects*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.subjects*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                {{ __('messages.subjects') }}
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                {{ __('messages.users') }}
            </a>

            <a href="{{ route('admin.programs') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.programs*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.programs*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                {{ __('messages.programs') }}
            </a>

            <a href="{{ secure_route('admin.applications') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.applications*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.applications*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('messages.applications') }}
            </a>

            <a href="{{ route('admin.academic-years.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.academic-years*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.academic-years*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />
                </svg>
                {{ __('messages.academic_years') }}
            </a>

            <a href="{{ route('admin.commissions') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.commissions*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.commissions*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ __('messages.commissions') }}
            </a>

            <a href="{{ route('admin.program-names.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.program-names*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.program-names*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                {{ __('messages.program_names') }}
            </a>
        </nav>
    </div>

    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 w-full relative space-y-4">
        <div class="flex justify-center mb-4">
            @include('components.navbar-toggles')
        </div>
        <form method="POST" action="{{ secure_route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-red-600 hover:border-red-200 rounded-xl font-medium transition-all duration-200 shadow-sm dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-red-500/10 dark:hover:text-red-400 dark:hover:border-red-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                {{ __('messages.logout') }}
            </button>
        </form>
    </div>
</aside>
