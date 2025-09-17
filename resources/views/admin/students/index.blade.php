@extends('layouts.admin')

@section('header', 'Manajemen Data Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Siswa</h2>
        <a href="{{ route('admin.students.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">NIS</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Kelas</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">UID Kartu</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Wali Murid</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($students as $student)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $student->name }}</td>
                        <td class="py-3 px-4">{{ $student->nis }}</td>
                        <td class="py-3 px-4">{{ $student->class }}</td>
                        <td class="py-3 px-4">{{ $student->card_uid ?: '-' }}</td>
                        <td class="py-3 px-4">{{ $student->guardian->name ?? 'Belum terhubung' }}</td>
                        <td class="py-3 px-4 flex items-center space-x-2">
                            <a href="{{ route('admin.students.edit', $student) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection

