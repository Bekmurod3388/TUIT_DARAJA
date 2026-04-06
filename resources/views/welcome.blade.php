<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.app_name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-script')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        @keyframes float-reverse {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(-5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-reverse { animation: float-reverse 7s ease-in-out infinite; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white dark:bg-slate-900 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 dark:bg-slate-900/80 dark:border-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center py-4 sm:py-0 sm:h-20 gap-4 sm:gap-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-gradient-to-tr from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-md transform -rotate-3 mr-3">
                            <svg class="h-6 w-6 text-white rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422M12 14l-6.16-3.422M12 14v7m0 0l-9-5V6.582M12 21l9-5V6.582M12 18V9" />
                            </svg>
                        </div>
                        <span class="font-extrabold text-2xl tracking-tight text-slate-900 dark:text-white">{{ __('messages.app_name') }}</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                    @include('components.navbar-toggles')

                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/my-applications') }}" class="text-slate-600 hover:text-slate-900 font-semibold text-sm transition-colors dark:text-slate-400 dark:hover:text-white">{{ __('messages.applications') }}</a>
                            <a href="{{ url('/my-applications') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                {{ __('messages.personal_cabinet') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900 font-semibold text-sm transition-colors dark:text-slate-400 dark:hover:text-white">{{ __('messages.login') }}</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                {{ __('messages.register') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] rounded-full bg-indigo-500/10 dark:bg-indigo-500/5 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] rounded-full bg-purple-500/10 dark:bg-purple-500/5 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-16 lg:py-0 mt-8 sm:mt-0">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left" data-aos="fade-right">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold mb-6 border border-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20" data-aos="fade-down" data-aos-delay="100">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600 mr-2 animate-pulse dark:bg-indigo-400"></span>
                        {{ __('messages.admission_open') }}
                    </div>
                    <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 dark:text-white sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl" data-aos="fade-up" data-aos-delay="200">
                        <span class="block xl:inline">{{ __('messages.hero_title_1') }}</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">{{ __('messages.hero_title_2') }}</span>
                    </h1>
                    <p class="mt-4 text-base text-slate-500 dark:text-slate-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 font-medium" data-aos="fade-up" data-aos-delay="300">
                        {{ __('messages.hero_desc') }}
                    </p>
                    <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0 flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="400">
                        @auth
                            <a href="{{ url('/my-applications') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-0.5">
                                {{ __('messages.go_to_applications') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg shadow-lg shadow-indigo-600/20 transition-all hover:-translate-y-0.5">
                                {{ __('messages.submit_doc') }}
                            </a>
                            <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 border text-base font-bold rounded-xl text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900 md:text-lg shadow-sm transition-all hover:-translate-y-0.5 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 dark:hover:text-white">
                                {{ __('messages.login') }}
                            </a>
                        @endauth
                    </div>
                </div>
                
                <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center" data-aos="zoom-in" data-aos-delay="300">
                    <div class="relative mx-auto w-full rounded-2xl shadow-2xl lg:max-w-md overflow-hidden bg-white border border-slate-100 dark:bg-slate-800 dark:border-slate-700 p-2 transform rotate-1 hover:rotate-0 transition-transform duration-500">
                        <div class="rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex items-center justify-center aspect-w-4 aspect-h-3 dark:bg-slate-900/50 dark:border-slate-800" style="min-height: 350px;">
                            <!-- Placeholder illustration (Abstract Data visual) -->
                            <div class="text-center p-8">
                                <div class="grid grid-cols-2 gap-4 opacity-80">
                                    <div class="h-24 w-24 rounded-2xl bg-indigo-500 rounded-tr-[40px] shadow-sm animate-float"></div>
                                    <div class="h-24 w-24 rounded-2xl bg-purple-500 rounded-bl-[40px] shadow-sm mt-8 animate-float-reverse"></div>
                                    <div class="h-24 w-24 rounded-2xl bg-emerald-400 rounded-tl-[40px] shadow-sm animate-float" style="animation-delay: 1s;"></div>
                                    <div class="h-24 w-24 rounded-2xl bg-blue-500 rounded-br-[40px] shadow-sm -mt-8 animate-float-reverse" style="animation-delay: 1.5s;"></div>
                                </div>
                                <h3 class="mt-8 text-xl font-bold text-slate-800 dark:text-slate-200">{{ __('messages.fully_online') }}</h3>
                                <p class="text-sm text-slate-500 mt-2 font-medium dark:text-slate-400">{{ __('messages.all_process_digital') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 dark:bg-slate-900 dark:border-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div class="flex justify-center items-center space-x-6 md:order-2 text-slate-400 dark:text-slate-500">
                <span class="text-sm font-medium">{{ __('messages.partner') }}</span>
                <span class="text-sm font-medium">|</span>
                <span class="text-sm font-medium">{{ __('messages.payme_payment') }}</span>
            </div>
            <div class="mt-4 md:mt-0 md:order-1">
                <p class="text-center text-sm text-slate-500 dark:text-slate-400 font-medium">
                    &copy; {{ date('Y') }} {{ __('messages.footer_rights') }}
                </p>
            </div>
        </div>
    </footer>

    @include('components.theme-toggle-scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ once: true, duration: 800, easing: 'ease-out-cubic' });
        });
    </script>
</body>
</html>
