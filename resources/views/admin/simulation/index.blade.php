@extends('layouts.admin')

@section('header', $pageTitle)

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Formulir Simulasi Absensi</h2>

    <p class="text-sm text-gray-600 mb-4">
        Gunakan formulir ini untuk melakukan simulasi absensi seolah-olah siswa melakukan tap kartu pada perangkat fisik.
        Ini akan memicu seluruh alur, termasuk penyimpanan data dan pengiriman notifikasi WhatsApp.
    </p>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.simulation.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="card_uid" class="block text-sm font-medium text-gray-700">Pilih Siswa (berdasarkan UID Kartu)</label>
                <input list="student-uids" id="card_uid" name="card_uid" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ketik atau pilih UID kartu siswa" required>
                <datalist id="student-uids">
                    @foreach($students as $student)
                        <option value="{{ $student->card_uid }}">{{ $student->name }} - {{ $student->class }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kirim Absensi
            </button>
        </div>
    </form>
</div>
@endsection

