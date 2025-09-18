@extends('layouts.admin')

@section('header', 'Rekapitulasi Absensi')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rekapitulasi Absensi</h1>
            <p class="mt-2 text-sm text-gray-600">Kelola dan pantau data kehadiran siswa</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">Filter Data</h2>
        </div>

        <form action="{{ route('admin.attendances.index') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <div class="relative">
                        <input type="date" name="start_date" id="start_date"
                               value="{{ $filters['start_date'] ?? '' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 bg-white shadow-sm">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <div class="relative">
                        <input type="date" name="end_date" id="end_date"
                               value="{{ $filters['end_date'] ?? '' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 bg-white shadow-sm">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="class" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <div class="relative">
                        <select name="class" id="class"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 bg-white shadow-sm appearance-none">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class }}" {{ ($filters['class'] ?? '') == $class ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 font-medium shadow-sm">
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter Data
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Data Kehadiran</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                            Nama Siswa
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                            Jam Masuk
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                            Jam Pulang
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($attendances as $index => $attendance)
                        <tr class="hover:bg-gray-50 transition duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $attendance['date'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-400 to-purple-400 flex items-center justify-center">
                                            <span class="text-xs font-medium text-white">{{ substr($attendance['user_name'], 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $attendance['user_name'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-full inline-block font-medium">
                                    {{ $attendance['class'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700 font-mono">
                                    {{ $attendance['check_in'] ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700 font-mono">
                                    {{ $attendance['check_out'] ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance['check_in'])
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Hadir
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tidak Hadir
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">Tidak ada data absensi</h3>
                                    <p class="text-sm text-gray-500 max-w-md">
                                        Tidak ada data absensi yang ditemukan. Silakan gunakan filter di atas untuk mencari data atau pastikan data telah diinput dengan benar.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
@endsection
