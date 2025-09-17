@extends('layouts.admin')

{{-- Variabel $pageTitle sekarang dikirim dari controller --}}
@section('header', $pageTitle)

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">{{ $pageTitle }}</h2>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PERBAIKAN: Menggunakan isset($guardian) untuk menentukan rute action form --}}
    <form action="{{ isset($guardian) ? route('admin.guardians.update', $guardian) : route('admin.guardians.store') }}" method="POST">
        @csrf
        @if (isset($guardian))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            {{-- PERBAIKAN: Menggunakan null coalescing operator (??) untuk menangani nilai default --}}
            <input type="text" name="name" id="name" value="{{ old('name', $guardian->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Alamat Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $guardian->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="guardian_phone" class="block text-gray-700 text-sm font-bold mb-2">Nomor WhatsApp</label>
            <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone', $guardian->guardian_phone ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                {{-- PERBAIKAN: Menghapus 'required' jika sedang dalam mode edit --}}
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ isset($guardian) ? '' : 'required' }}>
                @if (isset($guardian))
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                @endif
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ isset($guardian) ? 'Update Data' : 'Simpan Data' }}
            </button>
            <a href="{{ route('admin.guardians.index') }}" class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

