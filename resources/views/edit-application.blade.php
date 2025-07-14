<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arizani tahrirlash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen justify-center items-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-12 border border-gray-200">
        <h2 class="text-3xl font-bold mb-6 text-center text-amber-700">Arizani tahrirlash</h2>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl text-center font-semibold">
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
        <form method="POST" action="{{ route('applications.update', $application->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <fieldset class="border rounded-2xl p-8 mb-6 bg-gray-50">
                <legend class="font-semibold text-gray-700 px-2 text-lg">Talabgor ma'lumotlari</legend>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                        <label class="block text-base font-semibold mb-2">Familiya:</label>
                        <input type="text" name="last_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('last_name', $application->last_name) }}">
                    </div>
                    <div>
                        <label class="block text-base font-semibold mb-2">Ism:</label>
                        <input type="text" name="first_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('first_name', $application->first_name) }}">
                    </div>
                    <div>
                        <label class="block text-base font-semibold mb-2">Otasining ismi:</label>
                        <input type="text" name="middle_name" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('middle_name', $application->middle_name) }}">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                        <label class="block text-base font-semibold mb-2">Ixtisoslik nomi:</label>
                        <select name="specalization_id" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required>
                            <option value="">Barchasi</option>
                            @foreach($specalizations as $spec)
                                <option value="{{ $spec->id }}" @if(old('specalization_id', $application->specalization_id)==$spec->id) selected @endif>{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-base font-semibold mb-2">Fan nomi:</label>
                        <input type="text" name="subject" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('subject', $application->subject) }}">
                    </div>
                </div>
            </fieldset>
            <fieldset class="border rounded-2xl p-8 mb-6 bg-gray-50">
                <legend class="font-semibold text-gray-700 px-2 text-lg">Tashkilot</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-base font-semibold mb-2">Tashkilot nomi:</label>
                        <input type="text" name="organization" class="form-input w-full rounded-xl border-2 border-amber-400 bg-amber-50 focus:border-amber-500 focus:ring-amber-500 text-lg h-12 px-4" required value="{{ old('organization', $application->organization) }}">
                    </div>
                </div>
            </fieldset>
            <div class="flex justify-end gap-4 mt-6">
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">Saqlash</button>
                <a href="{{ route('my.applications') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold text-lg px-10 py-3 rounded-xl shadow">Bekor qilish</a>
            </div>
        </form>
    </div>
</div>
</body>
</html> 