<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dastur tahrirlash</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    @include('admin.sidebar')
    <main class="flex-1 p-10">
        <div class="bg-white rounded-xl shadow p-8 max-w-lg mx-auto">
            <h1 class="text-2xl font-bold mb-6">Dastur tahrirlash</h1>
            <form method="POST" action="{{ route('admin.programs.update', $program->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Dastur nomi</label>
                    <select id="program-select" name="name" class="w-full border rounded px-3 py-2" required onchange="fillCode()">
                        <option value="">Tanlang...</option>
                        <option value="Muhandislik geometriyasi va kompyuter grafikasi. Audio va video-texnologiyalari" data-code="05.01.01" {{ $program->name == 'Muhandislik geometriyasi va kompyuter grafikasi. Audio va video-texnologiyalari' ? 'selected' : '' }}>05.01.01 - Muhandislik geometriyasi va kompyuter grafikasi. Audio va video-texnologiyalari</option>
                        <option value="Tizimli tahlil, boshqaruv va axborotni qayta ishlash" data-code="05.01.02" {{ $program->name == 'Tizimli tahlil, boshqaruv va axborotni qayta ishlash' ? 'selected' : '' }}>05.01.02 - Tizimli tahlil, boshqaruv va axborotni qayta ishlash</option>
                        <option value="Informatikaning nazariy asoslari" data-code="05.01.03" {{ $program->name == 'Informatikaning nazariy asoslari' ? 'selected' : '' }}>05.01.03 - Informatikaning nazariy asoslari</option>
                        <option value="Hisoblash mashinalari, majmualari va kompyuter tarmoqlarining matematik va dasturiy ta’minoti" data-code="05.01.04" {{ $program->name == 'Hisoblash mashinalari, majmualari va kompyuter tarmoqlarining matematik va dasturiy ta’minoti' ? 'selected' : '' }}>05.01.04 - Hisoblash mashinalari, majmualari va kompyuter tarmoqlarining matematik va dasturiy ta’minoti</option>
                        <option value="Axborotlarni himoyalash usullari va tizimlari. Axborot xavfsizligi" data-code="05.01.05" {{ $program->name == 'Axborotlarni himoyalash usullari va tizimlari. Axborot xavfsizligi' ? 'selected' : '' }}>05.01.05 - Axborotlarni himoyalash usullari va tizimlari. Axborot xavfsizligi</option>
                        <option value="Matematik modellashtirish. Sonli usullar va dasturlar majmui" data-code="05.01.07" {{ $program->name == 'Matematik modellashtirish. Sonli usullar va dasturlar majmui' ? 'selected' : '' }}>05.01.07 - Matematik modellashtirish. Sonli usullar va dasturlar majmui</option>
                        <option value="Hujjatshunoslik. Arxivshunoslik. Kutubxonashunoslik" data-code="05.01.09" {{ $program->name == 'Hujjatshunoslik. Arxivshunoslik. Kutubxonashunoslik' ? 'selected' : '' }}>05.01.09 - Hujjatshunoslik. Arxivshunoslik. Kutubxonashunoslik</option>
                        <option value="Axborot olish tizimlari va jarayonlari" data-code="05.01.10" {{ $program->name == 'Axborot olish tizimlari va jarayonlari' ? 'selected' : '' }}>05.01.10 - Axborot olish tizimlari va jarayonlari</option>
                        <option value="Raqamli texnologiyalar va sun’iy intellect" data-code="05.01.11" {{ $program->name == 'Raqamli texnologiyalar va sun’iy intellect' ? 'selected' : '' }}>05.01.11 - Raqamli texnologiyalar va sun’iy intellect</option>
                        <option value="Telekommunikatsiya va kompyuter tizimlari, telekommunikatsiya tarmoqlari va qurilmalari. Axborotlarni taqsimlash" data-code="05.04.01" {{ $program->name == 'Telekommunikatsiya va kompyuter tizimlari, telekommunikatsiya tarmoqlari va qurilmalari. Axborotlarni taqsimlash' ? 'selected' : '' }}>05.04.01 - Telekommunikatsiya va kompyuter tizimlari, telekommunikatsiya tarmoqlari va qurilmalari. Axborotlarni taqsimlash</option>
                        <option value="Radiotexnika, radionavigatsiya, radiolokatsiya va televideniye tizimlari va qurilmalari. Mobil va optik tolali aloqa tizimlari" data-code="05.04.02" {{ $program->name == 'Radiotexnika, radionavigatsiya, radiolokatsiya va televideniye tizimlari va qurilmalari. Mobil va optik tolali aloqa tizimlari' ? 'selected' : '' }}>05.04.02 - Radiotexnika, radionavigatsiya, radiolokatsiya va televideniye tizimlari va qurilmalari. Mobil va optik tolali aloqa tizimlari</option>
                        <option value="Xizmat ko‘rsatish tarmoqlari iqtisodiyoti" data-code="08.00.05" {{ $program->name == 'Xizmat ko‘rsatish tarmoqlari iqtisodiyoti' ? 'selected' : '' }}>08.00.05 - Xizmat ko‘rsatish tarmoqlari iqtisodiyoti</option>
                        <option value="Raqamli iqtisodiyot va xalqaro raqamli integratsiya" data-code="08.00.16" {{ $program->name == 'Raqamli iqtisodiyot va xalqaro raqamli integratsiya' ? 'selected' : '' }}>08.00.16 - Raqamli iqtisodiyot va xalqaro raqamli integratsiya</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Dastur shifri</label>
                    <input type="text" id="program-code" name="code" class="w-full border rounded px-3 py-2" required readonly value="{{ $program->code }}">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Qisqacha ma'lumot</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2" rows="3" required>{{ $program->description }}</textarea>
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="is_visible" name="is_visible" value="1" class="mr-2" {{ $program->is_visible ? 'checked' : '' }}>
                    <label for="is_visible" class="font-semibold">Foydalanuvchilarga ko‘rsatilsinmi?</label>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Saqlash</button>
                <a href="{{ route('admin.programs') }}" class="ml-4 text-gray-600 hover:underline">Bekor qilish</a>
            </form>
            <script>
                function fillCode() {
                    var select = document.getElementById('program-select');
                    var code = select.options[select.selectedIndex].getAttribute('data-code');
                    document.getElementById('program-code').value = code || '';
                }
            </script>
        </div>
    </main>
</div>
</body>
</html> 