<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mening arizalarim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col items-center py-8">
        <div class="mb-6">
            <div class="w-24 h-24 flex items-center justify-center rounded-full border-4 border-amber-400 shadow bg-white text-6xl">
                🧑‍💻
            </div>
        </div>
        <div class="text-center mb-8">
            <div class="font-bold text-lg text-gray-800">{{ strtoupper($user->name ?? 'Foydalanuvchi') }}</div>
            <div class="text-xs text-gray-500 mt-1">EGOV ID foydalanuvchisi</div>
        </div>
        <nav class="w-full px-6">
            <ul class="space-y-2">
                <li>
                    <a href="/my-applications" class="flex items-center px-4 py-2 rounded-lg {{ request()->is('my-applications') ? 'bg-amber-100 text-amber-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                        </svg>
                        Mening arizalarim
                    </a>
                </li>
                <li>
                    <a href="/programs" class="flex items-center px-4 py-2 rounded-lg {{ request()->is('programs') ? 'bg-amber-100 text-amber-700 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h6" />
                        </svg>
                        Dasturlar
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
    <!-- Main Content -->
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8">
            <h1 class="text-2xl font-bold mb-2">Mening arizalarim</h1>
            <p class="mb-4 text-gray-600">Arizalar ro‘yxati</p>
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="fixed top-8 right-8 bg-green-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 text-lg font-semibold" x-init="setTimeout(() => show = false, 4000)">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">
                @if($specalizations->isEmpty())
                <div class="mb-4 flex justify-between items-center">
                    <span class="text-green-600 font-semibold">Ariza yuborish muddati tugagan!</span>
                </div>
                @else
                <div class="mb-4 flex justify-between items-center">
                    <span></span>
                    <button @click="open = true" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ariza qo‘shish
                    </button>
                </div>
                @endif
                <!-- Modal -->
                <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-12 relative border border-gray-200 max-h-[90vh] overflow-y-auto">
                        <h2 class="text-3xl font-bold mb-6 text-center text-amber-700">Ariza ma`lumotlarini kiritish</h2>
                        <div class="text-red-600 font-semibold mb-4 text-center text-lg">E'tibor bering:</div>
                        <div class="text-base text-gray-700 mb-8 text-center">
                            Ma'lumotlarni lotin yozuvida kiriting, yuklangan fayllaringiz PDF formatda va 2 mb dan oshmasligi kerak hamda bitta fandan faqat bir marta ariza qoldirish mumkin! So'ralgan barcha maydonlarni to'ldiring!
                        </div>
                        @if ($errors->any())
                            <div class="mb-4">
                                <div class="text-red-600 font-semibold">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            <fieldset class="border rounded-2xl p-8 mb-6 bg-gray-50">
                                <legend class="font-semibold text-gray-700 px-2 text-lg">Talabgor ma'lumotlari</legend>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Familiya:</label>
                                        <input type="text" name="last_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('last_name', $user->last_name ?? '') }}">
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Ism:</label>
                                        <input type="text" name="first_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('first_name', $user->first_name ?? '') }}">
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Otasining ismi:</label>
                                        <input type="text" name="middle_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('middle_name', $user->middle_name ?? '') }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Ixtisoslik nomi:</label>
                                        <select name="specalization_id" id="specalization-select" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required>
                                            <option value="">Barchasi</option>
                                            @foreach($specalizations as $spec)
                                                <option value="{{ $spec->id }}" data-subjects='@json($spec->subjects->pluck("fan", "fan_id"))'>{{ $spec->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Ta'lim turi:</label>
                                        <select name="education_type" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required>
                                            <option value="">Ta'lim turini tanlang</option>
                                            <option value="Mustaqil izlanuvchi (PhD)">Mustaqil izlanuvchi (PhD)</option>
                                            <option value="Doktorantura (DSc)">Doktorantura (DSc)</option>
                                            <option value="Mustaqil izlanuvchi (DSc)">Mustaqil izlanuvchi (DSc)</option>
                                            <option value="Tayanch doktorantura (PhD)">Tayanch doktorantura (PhD)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Fan nomi:</label>
                                        <select name="subject" id="subject-select" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required>
                                            <option value="">Fan tanlang</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="border rounded-2xl p-8 mb-6 bg-gray-50" x-data="{ org: '{{ old('organization_type', 'other') }}' }">
                                <legend class="font-semibold text-gray-700 px-2 text-lg">Tashkilot</legend>
                                <div class="flex items-center gap-8 mb-6">
                                    <label class="flex items-center text-base font-semibold">
                                        <input type="radio" name="organization_type" value="uzmu" x-model="org" class="mr-2 rounded text-amber-600 focus:ring-amber-500 h-5 w-5" required> TATU
                                    </label>
                                    <label class="flex items-center text-base font-semibold">
                                        <input type="radio" name="organization_type" value="other" x-model="org" class="mr-2 rounded text-amber-600 focus:ring-amber-500 h-5 w-5" required> Boshqa tashkilot
                                    </label>
                                </div>
                                <!-- O'zbekiston Milliy Universiteti uchun -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4" x-show="org === 'uzmu'">
                                    <!-- Telefon raqam har doim DOMda, faqat kerakli paytda enabled -->
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Telefon raqam:</label>
                                        <input type="text" name="phone" :disabled="!(org === 'uzmu' || org === 'other')" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" placeholder="+998 XX XXX-XX-XX" value="{{ old('phone', $user->phone ?? '') }}">
                                    </div>
                                    <!-- OAC fayli har doim DOMda, faqat kerakli paytda enabled -->
                                    <div>
                                        <label class="block text-base font-semibold mb-2">OAK byulleteni/tashkilot kengashi qarori:</label>
                                        <input type="file" name="oac_file" :disabled="!(org === 'uzmu' || org === 'other')" class="form-input w-full rounded-xl border-2 border-amber-400 focus:border-amber-500 focus:ring-amber-500" accept="application/pdf">
                                    </div>
                                </div>
                                <div class="mb-4" x-show="org === 'uzmu'">
                                    <span class="text-red-600 text-sm font-semibold">* Tayanch doktorantura (PhD) va Doktorantura (DSc) doktorantlari uchun buyruq yuklash majburiy emas</span>
                                </div>
                                <div class="mb-4" x-show="org === 'uzmu'">
                                    <label class="block text-base font-semibold mb-2">Ish buyrug'i</label>
                                    <input type="file" name="work_order_file" class="form-input w-full rounded-xl border-2 border-amber-400 focus:border-amber-500 focus:ring-amber-500" accept="application/pdf">
                                </div>
                                <!-- Boshqa tashkilot uchun -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4" x-show="org === 'other'">
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Tashkilot nomi:</label>
                                        <input type="text" name="organization"
                                            x-bind:value="org === 'uzmu' ? 'TATU' : (org === 'other' ? '' : '')"
                                            x-bind:readonly="org === 'uzmu'"
                                            class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4"
                                            :required="org === 'other'"
                                            value="{{ old('organization') }}">
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Telefon raqam:</label>
                                        <input type="text" name="phone" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" placeholder="+998 XX XXX-XX-XX" value="{{ old('phone', $user->phone ?? '') }}">
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">OAK byulleteni/tashkilot kengashi qarori:</label>
                                        <input type="file" name="oac_file" class="form-input w-full rounded-xl border-2 border-amber-400 focus:border-amber-500 focus:ring-amber-500" accept="application/pdf">
                                    </div>
                                    <div>
                                        <label class="block text-base font-semibold mb-2">Yo'llanma xati</label>
                                        <input type="file" name="direction_file" class="form-input w-full rounded-xl border-2 border-amber-400 focus:border-amber-500 focus:ring-amber-500" accept="application/pdf" :required="org === 'other'">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-base font-semibold mb-2">Kvitansiya PDF/JPEG</label>
                                        <span class="text-red-600 text-sm font-semibold block mb-2">Qo'shimcha fanlar uchun to'lov olinmaydi</span>
                                        <input type="file" name="receipt_file" class="form-input w-full rounded-xl border-2 border-amber-400 focus:border-amber-500 focus:ring-amber-500" accept="application/pdf,image/jpeg" :required="org === 'other'">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="flex justify-end gap-4 mt-6">
                                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">Yuborish</button>
                                <button type="button" @click="open = false" class="bg-red-600 hover:bg-red-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">Bekor qilish</button>
                            </div>
                        </form>
                        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-3xl" @click="open = false">&times;</button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border rounded">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-center">ID</th>
                            <th class="px-4 py-2 text-center">FIO</th>
                            <th class="px-4 py-2 text-center">Yo‘nalish</th>
                            <th class="px-4 py-2 text-center">Sertifikat</th>
                            <th class="px-4 py-2 text-center">Fan nomi</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Amal</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td class="px-4 py-2 text-center">{{ $app->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $app->last_name }} {{ $app->first_name }} {{ $app->middle_name }}</td>
                            <td class="px-4 py-2 text-center">{{ $app->specalization->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($app->payment_status === 'paid' && $app->is_scored && $app->status === 'accepted')
                                    <a href="{{ route('applications.certificate', $app->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded font-semibold" target="_blank">Yuklab olish</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">{{ $app->subject }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($app->payment_status === 'paid')
                                    <span class="inline-block bg-green-100 text-green-800 rounded px-2 py-1 text-xs font-semibold">To'langan</span>
                                @else
                                    <span class="inline-block bg-yellow-100 text-yellow-800 rounded px-2 py-1 text-xs font-semibold">To'lanmagan</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                @if($app->payment_status !== 'paid')
                                    <a href="{{ route('applications.pay', $app->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">Payme orqali to'lash</a>
                                @else
                                    <span class="text-green-600 font-semibold">✔</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">Arizalar topilmadi</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-xs text-gray-400 text-right">
                Malakaviy imtihon © {{ date('Y') }}
            </div>
        </div>
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const specSelect = document.getElementById('specalization-select');
        const subjectSelect = document.getElementById('subject-select');
        function updateSubjects() {
            const selected = specSelect.options[specSelect.selectedIndex];
            const subjects = selected.getAttribute('data-subjects');
            let options = '<option value="">Fan tanlang</option>';
            if (subjects) {
                const subjectsObj = JSON.parse(subjects);
                for (const [id, name] of Object.entries(subjectsObj)) {
                    options += `<option value="${name}">${name}</option>`;
                }
            }
            subjectSelect.innerHTML = options;
        }
        specSelect.addEventListener('change', updateSubjects);
        // Dastlabki yuklashda ham to'g'ri chiqsin
        updateSubjects();
    });
</script>
</body>
</html> 