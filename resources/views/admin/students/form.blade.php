@extends('layouts.admin')

@section('header', $pageTitle)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $pageTitle }}</h2>
                <p class="text-gray-600 text-sm">
                    {{ isset($student) ? 'Perbarui informasi siswa yang sudah ada' : 'Tambahkan siswa baru ke dalam sistem' }}
                </p>
            </div>
            <a href="{{ route('admin.students.index') }}"
               class="inline-flex items-center px-4 py-2.5 text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-red-800 font-medium">Terdapat kesalahan pada input</h3>
                    <div class="mt-2 text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ isset($student) ? route('admin.students.update', $student->id) : route('admin.students.store') }}" method="POST">
            @csrf
            @if(isset($student))
                @method('PUT')
            @endif

            <div class="p-6">
                <!-- Personal Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Personal</h3>
                            <p class="text-sm text-gray-600">Data dasar siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $student->name ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                   placeholder="Masukkan nama lengkap siswa">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $student->email ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                   placeholder="contoh@email.com">
                        </div>

                        <div>
                            <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">
                                NIS (Nomor Induk Siswa) <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nis"
                                   name="nis"
                                   value="{{ old('nis', $student->nis ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm font-mono"
                                   placeholder="Contoh: 1234567890">
                        </div>

                        <div>
                            <label for="class" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="class"
                                   name="class"
                                   value="{{ old('class', $student->class ?? '') }}"
                                   required
                                   placeholder="Contoh: X RPL 1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm">
                        </div>

                        <div>
                            <label for="guardian_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Wali Murid <span class="text-red-500">*</span>
                            </label>
                            <select id="guardian_id"
                                    name="guardian_id"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm">
                                <option value="">Pilih Wali Murid</option>
                                @forelse ($guardians as $guardian)
                                    <option value="{{ $guardian->id }}" {{ old('guardian_id', $student->guardian_id ?? '') == $guardian->id ? 'selected' : '' }}>
                                        {{ $guardian->name }} ({{ $guardian->guardian_phone }})
                                    </option>
                                @empty
                                    <option value="" disabled>Belum ada data wali murid tersedia</option>
                                @endforelse
                            </select>
                            <p class="mt-2 text-xs text-gray-500">
                                Pastikan data wali murid sudah ditambahkan terlebih dahulu
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Biometric Information Section -->
                <div class="mb-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Biometrik</h3>
                            <p class="text-sm text-gray-600">Data untuk sistem absensi (opsional)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="card_uid" class="block text-sm font-medium text-gray-700 mb-2">
                                UID Kartu RFID
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 ml-2">
                                    Opsional
                                </span>
                            </label>
                            <input type="text"
                                   id="card_uid"
                                   name="card_uid"
                                   value="{{ old('card_uid', $student->card_uid ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm font-mono"
                                   placeholder="Contoh: A1B2C3D4">
                            <p class="mt-2 text-xs text-gray-500">
                                UID dari kartu RFID siswa. Bisa diisi nanti
                            </p>
                        </div>

                        <div>
                            <label for="fingerprint_id" class="block text-sm font-medium text-gray-700 mb-2">
                                ID Sidik Jari
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 ml-2">
                                    Opsional
                                </span>
                            </label>
                            <input type="text"
                                   id="fingerprint_id"
                                   name="fingerprint_id"
                                   value="{{ old('fingerprint_id', $student->fingerprint_id ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm font-mono"
                                   placeholder="Contoh: FP001">
                            <p class="mt-2 text-xs text-gray-500">
                                ID unik dari mesin sidik jari. Bisa diisi nanti
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Information Section -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Keamanan Akun</h3>
                            <p class="text-sm text-gray-600">
                                {{ isset($student) ? 'Kosongkan jika tidak ingin mengubah password' : 'Buat password untuk akses sistem' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                                @unless(isset($student))
                                    <span class="text-red-500">*</span>
                                @endunless
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   {{ isset($student) ? '' : 'required' }}
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                   placeholder="Masukkan password">
                            @if(isset($student))
                                <p class="mt-2 text-xs text-gray-500">
                                    Kosongkan jika tidak ingin mengubah password
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                                @unless(isset($student))
                                    <span class="text-red-500">*</span>
                                @endunless
                            </label>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   {{ isset($student) ? '' : 'required' }}
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                   placeholder="Ulangi password">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span class="text-red-500">*</span> Wajib diisi
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.students.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200 text-sm">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md text-sm inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if(isset($student))
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            @endif
                        </svg>
                        {{ isset($student) ? 'Perbarui Siswa' : 'Simpan Siswa' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom select styling */
select {
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.25rem 1.25rem;
    padding-right: 2.75rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

/* Focus states */
input:focus,
select:focus {
    outline: none;
}

/* Required field indicator */
.required-field::after {
    content: "*";
    color: #EF4444;
    margin-left: 0.25rem;
}

/* Form validation styling */
.form-error {
    border-color: #EF4444;
}

.form-error:focus {
    border-color: #EF4444;
    ring-color: rgb(239 68 68 / 0.2);
}
</style>
@endsection
