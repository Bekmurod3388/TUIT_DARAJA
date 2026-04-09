<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.register') }} - {{ __('messages.app_name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-script')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        @keyframes float-reverse {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(-5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .animate-float { animation: float 7s ease-in-out infinite; }
        .animate-float-reverse { animation: float-reverse 8s ease-in-out infinite; }
        .glass-card { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(16px); 
            border: 1px solid rgba(255, 255, 255, 0.5); 
        }
        .dark .glass-card {
            background: rgba(30, 41, 59, 0.85); /* slate-800 */
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center relative py-12 px-4 selection:bg-indigo-500 selection:text-white dark:bg-slate-900 transition-colors duration-300">

    <div class="absolute right-4 top-4 z-50">
        @include('components.navbar-toggles')
    </div>

    <!-- Abstract Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-500/10 blur-3xl animate-float dark:bg-indigo-500/5"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-purple-500/10 blur-3xl animate-float-reverse dark:bg-purple-500/5"></div>
    </div>

    <div class="w-full max-w-md relative z-10 w-full mt-8 sm:mt-0">
        <!-- Header -->
        <div class="text-center mb-8" data-aos="fade-down">
            <div class="mx-auto h-16 w-16 bg-gradient-to-tr from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg transform -rotate-3 transition-transform hover:rotate-0 duration-300">
                <svg class="h-8 w-8 text-white rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight dark:text-white">{{ __('messages.app_name') }}</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium dark:text-slate-400">{{ __('messages.register_new_account') }}</p>
        </div>

        <!-- Glass container -->
        <div class="glass-card py-8 px-8 shadow-xl hover:shadow-2xl transition-shadow duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
            <!-- Xatolik xabarlari -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-red-500 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-bold">{{ __('messages.error_occurred') }}</span>
                    </div>
                    <ul class="list-disc list-inside text-sm pl-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ secure_url(route('register.post', [], false)) }}" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.last_name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm dark:bg-slate-900/50 dark:border-slate-700 dark:text-white dark:focus:ring-indigo-500" required value="{{ old('last_name') }}" placeholder="{{ __('messages.last_name') }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.first_name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm dark:bg-slate-900/50 dark:border-slate-700 dark:text-white dark:focus:ring-indigo-500" required value="{{ old('first_name') }}" placeholder="{{ __('messages.first_name') }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.middle_name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="middle_name" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm dark:bg-slate-900/50 dark:border-slate-700 dark:text-white dark:focus:ring-indigo-500" required value="{{ old('middle_name') }}" placeholder="{{ __('messages.middle_name') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.phone_number') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <input id="phone" name="phone" type="text" autocomplete="tel" required class="block w-full pl-10 px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm dark:bg-slate-900/50 dark:border-slate-700 dark:text-white dark:focus:ring-indigo-500" placeholder="+998 (__) ___-__-__" value="{{ old('phone') }}" maxlength="19">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.password') }} <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm dark:bg-slate-900/50 dark:border-slate-700 dark:text-white dark:focus:ring-indigo-500" required placeholder="{{ __('messages.password') }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 dark:text-slate-300">{{ __('messages.password_confirm') }} <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm dark:bg-slate-900/50 dark:border-slate-700 dark:text-white dark:focus:ring-indigo-500" required placeholder="{{ __('messages.password_confirm') }}">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('messages.create_account') }}
                    </button>
                </div>
            </form>

            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-slate-400 dark:bg-slate-800 dark:text-slate-500">{{ __('messages.or') }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('oneid.login') }}" class="w-full flex items-center justify-center px-4 py-3 border border-slate-300 rounded-xl shadow-sm bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-700">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.492-1.1-1.099s.493-1.1 1.1-1.1 1.1.493 1.1 1.1-.493 1.099-1.1 1.099zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                        </svg>
                        {{ __('messages.login_with_oneid') }}
                    </a>
                </div>
            </div>

            <div class="mt-6 text-center border-t border-slate-200 pt-6 dark:border-slate-700">
                <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('messages.already_have_account') }}</span>
                <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-500 transition-colors inline-block mt-1 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('messages.login') }}</a>
            </div>
        </div>
    </div>

@include('components.theme-toggle-scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({ once: true, duration: 600, easing: 'ease-out' });
        }
    });

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
</body>
</html>
