@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('content')
<div class="bg-white rounded-xl shadow p-8">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-100 rounded-lg p-6 flex items-center gap-4 shadow">
            <div class="text-4xl">👤</div>
            <div>
                <div class="text-2xl font-bold text-blue-900">{{ $usersCount }}</div>
                <div class="text-blue-800 font-semibold">Foydalanuvchilar soni</div>
            </div>
        </div>
        <div class="bg-yellow-100 rounded-lg p-6 flex items-center gap-4 shadow">
            <div class="text-4xl">📄</div>
            <div>
                <div class="text-2xl font-bold text-yellow-900">{{ $applicationsCount }}</div>
                <div class="text-yellow-800 font-semibold">Arizalar soni</div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="/admin/users" class="block bg-blue-50 hover:bg-blue-100 rounded-lg p-6 shadow text-center">
            <div class="text-3xl mb-2">👤</div>
            <div class="font-semibold text-lg">Foydalanuvchilar</div>
            <div class="text-sm text-gray-500 mt-1">Barcha foydalanuvchilarni ko‘rish</div>
        </a>
        <a href="/admin/programs" class="block bg-green-50 hover:bg-green-100 rounded-lg p-6 shadow text-center">
            <div class="text-3xl mb-2">📦</div>
            <div class="font-semibold text-lg">Dasturlar</div>
            <div class="text-sm text-gray-500 mt-1">Dastur qo‘shish va boshqarish</div>
        </a>
        <a href="/admin/applications" class="block bg-yellow-50 hover:bg-yellow-100 rounded-lg p-6 shadow text-center">
            <div class="text-3xl mb-2">📄</div>
            <div class="font-semibold text-lg">Arizalar</div>
            <div class="text-sm text-gray-500 mt-1">Barcha arizalarni ko‘rish</div>
        </a>
    </div>
</div>
@endsection 