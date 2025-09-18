@extends('layouts.admin')

@section('header', 'Manajemen Data Siswa')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Daftar Siswa</h2>
                <p class="text-gray-600 text-sm">Kelola data siswa dan informasi terkait</p>
            </div>
            <a href="{{ route('admin.students.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-medium text-sm rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nama Siswa
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            NIS
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            UID Kartu
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Wali Murid
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono">{{ $student->nis }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $student->class }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->card_uid)
                                    <span class="text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">
                                        {{ $student->card_uid }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400 italic">Belum tersedia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->guardian)
                                    <div class="text-sm text-gray-900">{{ $student->guardian->name }}</div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Belum terhubung
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                       class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center text-red-600 hover:text-red-900 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada data siswa</h3>
                                    <p class="text-gray-500 mb-4">Mulai dengan menambahkan siswa baru ke dalam sistem</p>
                                    <a href="{{ route('admin.students.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium text-sm rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Siswa Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $students->firstItem() }} - {{ $students->lastItem() }} dari {{ $students->total() }} data
                    </div>
                    <div class="pagination-wrapper">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Custom pagination styling */
.pagination-wrapper .pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.25rem;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    padding: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6B7280;
    background-color: white;
    border: 1px solid #E5E7EB;
    text-decoration: none;
    transition: all 0.2s ease;
    border-radius: 0.5rem;
}

.pagination-wrapper .page-link:hover {
    background-color: #F9FAFB;
    color: #374151;
    border-color: #D1D5DB;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #111827;
    color: white;
    border-color: #111827;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #D1D5DB;
    cursor: not-allowed;
}

.pagination-wrapper .page-item.disabled .page-link:hover {
    background-color: white;
    color: #D1D5DB;
    border-color: #E5E7EB;
}
</style>
@endsection
