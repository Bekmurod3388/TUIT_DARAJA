<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.edit_application') }} - {{ __('messages.app_name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 relative selection:bg-indigo-500 selection:text-white">

    <!-- Abstract Decoration -->
    <div class="fixed top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none z-0"></div>
    <div class="fixed bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-purple-500/10 blur-3xl pointer-events-none z-0"></div>

    <div class="flex min-h-screen justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="w-full max-w-4xl">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('messages.edit_application') }}</h2>
                    <p class="text-slate-500 mt-2 font-medium">{{ __('messages.edit_application_number', ['id' => $application->id]) }}</p>
                </div>
                <a href="{{ route('my.applications') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('messages.go_back') }}
                </a>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-6 flex items-center justify-between p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="font-bold text-red-800">{{ __('messages.error_exists') }}</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1 pl-8">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="glass-panel rounded-2xl shadow-xl border border-slate-200 overflow-hidden bg-white">
                <form method="POST" action="{{ route('applications.update', $application->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="p-6 md:p-8">
                        <!-- Talabgor ma'lumotlari -->
                        <div class="mb-10">
                            <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center pb-3 border-b border-slate-100">
                                <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                                {{ __('messages.applicant_info') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('messages.last_name') }}</label>
                                    <input type="text" name="last_name" class="w-full rounded-xl border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 bg-slate-50 transition-colors" required value="{{ old('last_name', $application->last_name) }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('messages.first_name') }}</label>
                                    <input type="text" name="first_name" class="w-full rounded-xl border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 bg-slate-50 transition-colors" required value="{{ old('first_name', $application->first_name) }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('messages.middle_name') }}</label>
                                    <input type="text" name="middle_name" class="w-full rounded-xl border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 bg-slate-50 transition-colors" required value="{{ old('middle_name', $application->middle_name) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Ta'lim va Fan -->
                        <div class="mb-10">
                            <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center pb-3 border-b border-slate-100">
                                <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                                {{ __('messages.specialization_and_subject') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-indigo-50/50 p-6 rounded-xl border border-indigo-100/50">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('messages.specialization_name') }}</label>
                                    <select name="specalization_id" class="w-full rounded-xl border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 bg-white transition-colors cursor-pointer" required>
                                        <option value="">{{ __('messages.select') }}</option>
                                        @foreach($specalizations as $spec)
                                            <option value="{{ $spec->id }}" @if(old('specalization_id', $application->specalization_id) == $spec->id) selected @endif>{{ $spec->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('messages.subject_name') }}</label>
                                    <input type="text" name="subject" class="w-full rounded-xl border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 bg-white transition-colors" required value="{{ old('subject', $application->subject) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Tashkilot -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center pb-3 border-b border-slate-100">
                                <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">3</span>
                                {{ __('messages.organization_info') }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('messages.organization_name') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="organization" class="w-full rounded-xl border-slate-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 bg-slate-50 transition-colors" required value="{{ old('organization', $application->organization) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer / Actions -->
                    <div class="bg-slate-50 px-6 py-5 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:gap-4">
                        <a href="{{ route('my.applications') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            {{ __('messages.cancel') }}
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent shadow-sm text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            {{ __('messages.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
