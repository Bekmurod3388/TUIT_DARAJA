<aside class="w-64 bg-white shadow-lg flex flex-col items-center py-8">
    <div class="mb-6">
        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=Admin" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-blue-400 shadow">
    </div>
    <div class="text-center mb-8">
        <div class="font-bold text-lg text-gray-800">ADMIN PANEL</div>
        <div class="text-xs text-gray-500 mt-1">Tizim administrator</div>
    </div>
    <nav class="w-full px-6">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Foydalanuvchilar
                </a>
            </li>
            <li>
                <a href="{{ route('admin.programs') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.programs') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h6" />
                    </svg>
                    Dasturlar
                </a>
            </li>
            <li>
                <a href="{{ route('admin.applications') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.applications') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                    </svg>
                    Arizalar
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto w-full px-6">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center mt-8 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside> 