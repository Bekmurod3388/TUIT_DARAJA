<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.my_applications') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
<body class="min-h-screen bg-slate-50 text-slate-900 flex h-screen overflow-hidden selection:bg-indigo-500 selection:text-white transition-colors duration-300 dark:bg-slate-900 dark:text-slate-100">

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
                @php $fullName = trim(($user->last_name ?? '').' '.($user->first_name ?? '').' '.($user->middle_name ?? ''));
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
            @php $menuInitials = mb_substr(trim($user->first_name ?? 'F'), 0, 1) . mb_substr(trim($user->last_name ?? 'U'), 0, 1);  @endphp
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200 text-xs dark:bg-indigo-900/50 dark:text-indigo-300 dark:border-indigo-700">{{ $menuInitials }}</div>
        </header>

        <!-- Main Content Scrollable Area -->
        <main class="flex-1 p-4 md:p-10 lg:p-12 overflow-x-hidden overflow-y-auto custom-scrollbar relative w-full">
            <!-- Abstract Decoration -->
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none z-0 dark:bg-indigo-500/5"></div>
        
        <div class="max-w-6xl mx-auto relative z-10" data-aos="fade-in" x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">
            <!-- Header Section -->
            <div class="mb-8 pb-6 border-b border-slate-200 dark:border-slate-800" data-aos="fade-right">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight dark:text-white">{{ __('messages.my_applications') }}</h1>
                <p class="text-slate-500 mt-2 font-medium dark:text-slate-400">{{ __('messages.all_applications') }}</p>
            </div>

            <!-- Slide-over Drawer -->
            <div id="application-modal"
                 class="fixed inset-0 z-50 overflow-hidden {{ $errors->any() ? '' : 'hidden' }}"
                 aria-labelledby="slide-over-title"
                 role="dialog"
                 aria-modal="true">

                <!-- Background overlay and Blur -->
                <div
                     x-transition:enter="ease-in-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity dark:bg-slate-900/80"
                     data-close-application-modal
                     aria-hidden="true"></div>

                <div class="fixed inset-0 z-10 flex items-center justify-center p-4 sm:p-6 lg:p-8">
                    <!-- Modal panel -->
                    <div
                         x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                         x-transition:enter-start="scale-95 opacity-0"
                         x-transition:enter-end="scale-100 opacity-100"
                         x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                         x-transition:leave-start="scale-100 opacity-100"
                         x-transition:leave-end="scale-95 opacity-0"
                         class="pointer-events-auto my-auto flex max-h-[88vh] w-[96vw] max-w-[1680px]">

                        <div class="flex w-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-800">
                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6 lg:px-10 xl:px-12">
                                <div class="sticky top-0 z-10 mb-6 flex items-center justify-between border-b border-slate-100 bg-white/95 pb-4 pt-1 backdrop-blur dark:border-slate-700 dark:bg-slate-800/95">
                                    <h3 class="text-2xl leading-6 font-bold text-slate-900 dark:text-white" id="modal-title">{{ __('messages.enter_application_data') }}</h3>
                                    <button type="button" data-close-application-modal class="text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-full p-2 transition-colors dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white dark:bg-slate-700/50">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>



                                    @if($errors->any())
                                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 dark:bg-red-500/10 dark:border-red-500/20">
                                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1 dark:text-red-400">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ secure_route('applications.store') }}" enctype="multipart/form-data" class="space-y-8">
                                        @csrf
                                        
                                        <!-- Talabgor ma'lumotlari -->
                                        <div>
                                            <h4 class="text-lg font-bold text-slate-800 mb-4 dark:text-white">
                                                {{ __('messages.applicant_data') }}

                                            </h4>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 bg-slate-50 p-5 rounded-xl border border-slate-100 dark:bg-slate-900/50 dark:border-slate-700">
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.last_name') }}</label>
                                                    <input type="text" name="last_name" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-slate-800 bg-white dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" required value="{{ old('last_name', $user->last_name ?? '') }}">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.first_name') }}</label>
                                                    <input type="text" name="first_name" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-slate-800 bg-white dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" required value="{{ old('first_name', $user->first_name ?? '') }}">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.middle_name') }}</label>
                                                    <input type="text" name="middle_name" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-slate-800 bg-white dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" required value="{{ old('middle_name', $user->middle_name ?? '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ta'lim va dars -->
                                        <div>
                                            <h4 class="text-lg font-bold text-slate-800 mb-4 dark:text-white">
                                                {{ __('messages.education_direction') }}

                                            </h4>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 bg-slate-50 p-5 rounded-xl border border-slate-100 dark:bg-slate-900/50 dark:border-slate-700">
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.specalization') }}</label>
                                                    <select name="specalization_id" id="specalization-select" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-slate-800 bg-white dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" required>
                                                        <option value="">{{ __('messages.select') }}...</option>
                                                        @foreach($specalizations as $spec)
                                                            <option value="{{ $spec->id }}" data-subjects='@json($spec->subjects->pluck("fan", "fan_id"))'>{{ $spec->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.education_type') }}</label>
                                                    <select name="education_type" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-slate-800 bg-white dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" required>
                                                        <option value="">{{ __('messages.select') }}...</option>
                                                        <option value="Mustaqil izlanuvchi (PhD)">Mustaqil izlanuvchi (PhD)</option>
                                                        <option value="Doktorantura (DSc)">Doktorantura (DSc)</option>
                                                        <option value="Mustaqil izlanuvchi (DSc)">Mustaqil izlanuvchi (DSc)</option>
                                                        <option value="Tayanch doktorantura (PhD)">Tayanch doktorantura (PhD)</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.subject_name') }}</label>
                                                    <select name="subject" id="subject-select" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 text-slate-800 bg-white dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" required>
                                                        <option value="">{{ __('messages.select_subject') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tashkilot va hujjatlar -->
                                        <div>
                                            <h4 class="text-lg font-bold text-slate-800 mb-4 dark:text-white">
                                                {{ __('messages.organization_files') }}

                                            </h4>
                                            
                                            <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 dark:bg-slate-900/50 dark:border-slate-700">
                                                <div class="flex items-center gap-6 mb-6 pb-4 border-b border-slate-200 dark:border-slate-700">
                                                    <label class="flex items-center cursor-pointer group">
                                                        <input type="radio" name="organization_type" value="uzmu" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500 rounded-full dark:bg-slate-800 dark:border-slate-600 dark:checked:bg-indigo-500" required {{ old('organization_type', 'other') === 'uzmu' ? 'checked' : '' }}>
                                                        <span class="ml-2.5 font-semibold text-slate-700 group-hover:text-indigo-600 transition-colors dark:text-slate-300 dark:group-hover:text-indigo-400">{{ __('messages.tuit_employee') }}</span>
                                                    </label>
                                                    <label class="flex items-center cursor-pointer group">
                                                        <input type="radio" name="organization_type" value="other" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500 rounded-full dark:bg-slate-800 dark:border-slate-600 dark:checked:bg-indigo-500" required {{ old('organization_type', 'other') === 'other' ? 'checked' : '' }}>
                                                        <span class="ml-2.5 font-semibold text-slate-700 group-hover:text-indigo-600 transition-colors dark:text-slate-300 dark:group-hover:text-indigo-400">{{ __('messages.other_organization') }}</span>
                                                    </label>
                                                </div>

                                                <!-- TATU uchun -->
                                                <div id="org-section-uzmu" class="{{ old('organization_type', 'other') === 'uzmu' ? '' : 'hidden' }}">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                                        <div>
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.phone_number') }}</label>
                                                            <input type="text" name="phone" data-org-manage="true" data-org-required="false" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" placeholder="+998 XX XXX-XX-XX" value="{{ old('phone', $user->phone ?? '') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.oac_bulletin') }} <span class="text-slate-400 font-normal dark:text-slate-500">(PDF)</span></label>
                                                            <input type="file" name="oac_file" data-org-manage="true" data-org-required="false" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-lg bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-indigo-500/20 dark:file:text-indigo-400 dark:hover:file:bg-indigo-500/30" accept="application/pdf">
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center justify-between dark:text-slate-300">
                                                                <span>{{ __('messages.work_order') }} <span class="text-slate-400 font-normal dark:text-slate-500">(PDF)</span></span>
                                                                <span class="text-xs font-normal text-amber-600 bg-amber-50 px-2 py-0.5 rounded dark:bg-amber-500/10 dark:text-amber-400">*Tayanch doktorantlar uchun majburiy emas</span>
                                                            </label>
                                                            <input type="file" name="work_order_file" data-org-manage="true" data-org-required="false" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-lg bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-indigo-500/20 dark:file:text-indigo-400 dark:hover:file:bg-indigo-500/30" accept="application/pdf">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Boshqa tashkilot uchun -->
                                                <div id="org-section-other" class="{{ old('organization_type', 'other') === 'other' ? '' : 'hidden' }}">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                                        <div>
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">Tashkilot nomi <span class="text-red-500">*</span></label>
                                                            <input type="text" name="organization" data-org-manage="true" data-org-required="true" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" value="{{ old('organization') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.phone_number') }}</label>
                                                            <input type="text" name="phone" data-org-manage="true" data-org-required="false" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 dark:bg-slate-800 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500" placeholder="+998 XX XXX-XX-XX" value="{{ old('phone', $user->phone ?? '') }}">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.oac_bulletin') }} <span class="text-slate-400 font-normal dark:text-slate-500">(PDF)</span></label>
                                                            <input type="file" name="oac_file" data-org-manage="true" data-org-required="false" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-lg bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-indigo-500/20 dark:file:text-indigo-400 dark:hover:file:bg-indigo-500/30" accept="application/pdf">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.direction_letter') }} <span class="text-red-500">*</span> <span class="text-slate-400 font-normal dark:text-slate-500">(PDF)</span></label>
                                                            <input type="file" name="direction_file" data-org-manage="true" data-org-required="true" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-lg bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-indigo-500/20 dark:file:text-indigo-400 dark:hover:file:bg-indigo-500/30" accept="application/pdf">
                                                        </div>
                                                        <div class="md:col-span-2 border-t border-slate-200 dark:border-slate-700 mt-2 pt-5">
                                                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center justify-between dark:text-slate-300">
                                                                <div>{{ __('messages.receipt_copy') }} <span class="text-red-500">*</span> <span class="text-slate-400 font-normal dark:text-slate-500">(PDF/JPEG)</span></div>
                                                                <span class="text-xs font-normal text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded dark:bg-emerald-500/10 dark:text-emerald-400">Qo'shimcha fanlar uchun to'lov olinmaydi</span>
                                                            </label>
                                                            <input type="file" name="receipt_file" data-org-manage="true" data-org-required="true" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-lg bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-emerald-500/20 dark:file:text-emerald-400 dark:hover:file:bg-emerald-500/30" accept="application/pdf,image/jpeg,image/png,image/jpg">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sticky bottom-0 bg-slate-50 px-4 py-6 sm:px-8 flex flex-col sm:flex-row border-t border-slate-200 dark:bg-slate-900/95 dark:border-slate-700 justify-end gap-3 mt-8 -mx-4 sm:-mx-6 lg:-mx-10 xl:-mx-12 -mb-6 backdrop-blur">
                                            <button type="button" data-close-application-modal class="inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors w-full sm:w-auto dark:bg-slate-800 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                                                {{ __('messages.cancel') }}

                                            </button>
                                            <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-indigo-600 text-base font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors w-full sm:w-auto">
                                                {{ __('messages.save_application') }}

                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-8 flex items-center justify-between p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400" x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" x-on:click="show = false" class="text-emerald-600 hover:text-emerald-800 focus:outline-none dark:text-emerald-400 dark:hover:text-emerald-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <div class="mb-6 glass-panel rounded-2xl border border-slate-200/80 bg-white/90 p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/80" data-aos="fade-up">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('messages.my_applications') }}</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ $applications->isEmpty() ? __('messages.no_applications') : __('messages.all_applications') }}
                        </p>
                    </div>

                    @if(!$specalizations->isEmpty())
                        <button type="button" data-open-application-modal class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:shadow-lg sm:w-auto">
                            <svg class="h-5 w-5 transition-transform duration-200 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>{{ __('messages.new_application') }}</span>
                        </button>
                    @else
                        <div class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('messages.deadline_passed') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Desktop Data Table -->
            <div class="hidden md:block w-full overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md dark:border-slate-700 dark:bg-slate-800/90" data-aos="fade-up" data-aos-delay="100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600 dark:bg-transparent dark:text-slate-300">
                        <thead class="border-b border-slate-200 bg-slate-50/90 text-xs uppercase text-slate-500 dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold text-center w-16">ID</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-left">F.I.O</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-left">Yo‘nalish / Fan</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">To'lov holati</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">Natija</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">Amal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white/70 dark:divide-slate-700 dark:bg-slate-800/70">
                        @forelse($applications as $app)
                            <tr class="group bg-transparent transition-colors duration-150 hover:bg-slate-50 dark:hover:bg-slate-700/40">
                                <td class="px-6 py-4 text-center font-medium text-slate-900 border-l-4 {{ $app->payment_status === 'paid' ? 'border-emerald-500' : 'border-amber-400' }} dark:text-white">
                                    #{{ $app->id }}

                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $app->last_name }} {{ $app->first_name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5 dark:text-slate-400">{{ $app->middle_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 line-clamp-1 dark:text-slate-200" title="{{ $app->specalization->name ?? '-' }}">{{ $app->specalization->name ?? '-' }}</div>
                                    <div class="text-xs text-indigo-600 font-medium mt-0.5 flex items-center dark:text-indigo-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ $app->subject }}

                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($app->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></span> To'langan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse dark:bg-amber-400"></span> To'lanmagan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($app->payment_status === 'paid' && $app->is_scored && $app->status === 'accepted')
                                        <a href="{{ route('applications.certificate', $app->id) }}" class="inline-flex items-center justify-center p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 hover:text-indigo-700 rounded-lg transition-colors group-hover:shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20 dark:hover:text-indigo-300" title="Sertifikatni yuklash" target="_blank">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </a>
                                    @else
                                        <span class="text-slate-300 font-medium flex justify-center items-center dark:text-slate-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($app->payment_status !== 'paid')
                                        <a href="{{ route('applications.pay', $app->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-wide text-white bg-[#00A19D] hover:bg-[#008f8b] rounded-lg shadow-sm transition-colors whitespace-nowrap">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            To'lash
                                        </a>
                                    @else
                                        <span class="inline-flex items-center text-emerald-600 font-semibold bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Mofaqqiyatli
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="bg-transparent px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/70">
                                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-500 font-medium dark:text-slate-400">{{ __('messages.no_applications') }}</p>
                                        @if(!$specalizations->isEmpty())
                                            <button type="button" data-open-application-modal class="mt-4 inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 transition-colors hover:bg-indigo-100 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-300 dark:hover:bg-indigo-500/20">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                <span>{{ __('messages.submit_new_application') }}</span>
                                            </button>
                                        @endif
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
                @forelse($applications as $app)
                    <div class="rounded-xl border border-slate-200 bg-white/95 p-4 shadow-sm transition-transform transform hover:-translate-y-1 dark:border-slate-700 dark:bg-slate-800/90 border-l-4 {{ $app->payment_status === 'paid' ? 'border-emerald-500' : 'border-amber-400' }}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base leading-tight dark:text-white">{{ $app->last_name }} {{ $app->first_name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 dark:text-slate-400">#{{ $app->id }} &bull; {{ $app->middle_name }}</p>
                            </div>
                            @if($app->payment_status === 'paid')
                                <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest shrink-0 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    To'langan
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 rounded text-[10px] font-bold bg-amber-100 text-amber-800 uppercase tracking-widest shrink-0 animate-pulse dark:bg-amber-500/10 dark:text-amber-400">
                                    To'lanmagan
                                </span>
                            @endif
                        </div>
                        
                        <div class="mb-4 rounded-lg border border-slate-100 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-900/60">
                            <div class="text-xs font-semibold text-slate-800 mb-1 dark:text-slate-200">{{ $app->specalization->name ?? '-' }}</div>
                            <div class="text-[11px] text-indigo-600 font-bold flex items-center dark:text-indigo-400">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                {{ $app->subject }}

                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700">
                            <div class="flex items-center">
                                @if($app->payment_status === 'paid' && $app->is_scored && $app->status === 'accepted')
                                    <a href="{{ route('applications.certificate', $app->id) }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300" target="_blank">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Sertifikat
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium flex items-center dark:text-slate-500">Natija: Kutilyapti</span>
                                @endif
                            </div>
                            
                            <div>
                                @if($app->payment_status !== 'paid')
                                    <a href="{{ route('applications.pay', $app->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-wide text-white bg-[#00A19D] hover:bg-[#008f8b] rounded-lg shadow-sm">
                                        Payme d'an to'lash
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-slate-200 bg-white/95 p-8 text-center shadow-sm dark:border-slate-700 dark:bg-slate-800/90">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/70">
                            <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium text-sm dark:text-slate-400">{{ __('messages.no_applications') }}</p>
                        @if(!$specalizations->isEmpty())
                            <button type="button" data-open-application-modal class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-3 text-sm font-semibold text-white shadow-md">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>{{ __('messages.submit_new_application') }}</span>
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center text-xs text-slate-400 dark:border-slate-800 dark:text-slate-500">
                <div class="flex items-center gap-2 mb-2 md:mb-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Tizim himoyalangan va EGOV orqali tasdiqlangan</span>
                </div>
                <div>{{ __('messages.footer_rights') }} &copy; {{ date('Y') }} barcha huquqlar himoyalangan.</div>
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

        const applicationModal = document.getElementById('application-modal');
        const openModalButtons = document.querySelectorAll('[data-open-application-modal]');
        const closeModalButtons = document.querySelectorAll('[data-close-application-modal]');
        const uzmuSection = document.getElementById('org-section-uzmu');
        const otherSection = document.getElementById('org-section-other');
        const orgRadios = document.querySelectorAll('input[name="organization_type"]');

        function setSectionState(section, active) {
            if (!section) {
                return;
            }

            section.classList.toggle('hidden', !active);

            section.querySelectorAll('[data-org-manage="true"]').forEach((field) => {
                field.disabled = !active;
                field.required = active && field.dataset.orgRequired === 'true';
            });
        }

        function syncOrganizationSections() {
            const selectedOrg = document.querySelector('input[name="organization_type"]:checked')?.value || 'other';
            setSectionState(uzmuSection, selectedOrg === 'uzmu');
            setSectionState(otherSection, selectedOrg === 'other');
        }

        function openApplicationModal() {
            if (!applicationModal) {
                return;
            }

            applicationModal.classList.remove('hidden');
            syncOrganizationSections();
        }

        function closeApplicationModal() {
            if (!applicationModal) {
                return;
            }

            applicationModal.classList.add('hidden');
        }

        openModalButtons.forEach((button) => {
            button.addEventListener('click', openApplicationModal);
        });

        closeModalButtons.forEach((button) => {
            button.addEventListener('click', closeApplicationModal);
        });

        orgRadios.forEach((radio) => {
            radio.addEventListener('change', syncOrganizationSections);
        });

        syncOrganizationSections();
        
        const specSelect = document.getElementById('specalization-select');
        const subjectSelect = document.getElementById('subject-select');
        function updateSubjects() {
            if(!specSelect) return;
            const selected = specSelect.options[specSelect.selectedIndex];
            const subjects = selected.getAttribute('data-subjects');
            let options = '<option value="">Fan tanlang</option>';
            if (subjects) {
                const subjectsObj = JSON.parse(subjects);
                for (const [id, name] of Object.entries(subjectsObj)) {
                    options += `<option value="${name}">${name}</option>`;
                }
            }
            if(subjectSelect) subjectSelect.innerHTML = options;
        }
        if(specSelect) {
            specSelect.addEventListener('change', updateSubjects);
            updateSubjects();
        }
    });
</script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>
@php /**PATH /var/www/TUIT_DARAJA/resources/views/my-applications.blade.php ENDPATH**/  @endphp
