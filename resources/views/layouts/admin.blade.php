<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - Absensi Sekolah</title>

    <!-- Menggunakan Tailwind Play CDN untuk mendukung kelas dinamis -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <!-- AlpineJS for interactivity -->
    {{-- PERBAIKAN: Menambahkan kembali atribut 'defer' yang krusial --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex h-screen bg-gray-200" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside
            class="w-64 bg-gray-800 text-white flex-shrink-0 flex flex-col transition-all duration-300 fixed lg:relative z-20 h-full"
            :class="{'w-64': sidebarOpen, 'w-0': !sidebarOpen, 'lg:w-64': sidebarOpen, 'lg:w-0': !sidebarOpen}"
            @click.away="sidebarOpen = false"
            x-cloak
        >
            <div class="h-16 flex items-center justify-center text-2xl font-bold">
                <span :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}" class="transition-opacity duration-200">Absensi Admin</span>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    <span :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}" class="transition-opacity duration-200">Dashboard</span>
                </a>
                <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.students.*') ? 'bg-gray-900' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                    <span :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}" class="transition-opacity duration-200">Data Siswa</span>
                </a>
                <a href="{{ route('admin.guardians.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.guardians.*') ? 'bg-gray-900' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zm-2 5a5 5 0 00-4.545 2.918A9.953 9.953 0 006 17a9.953 9.953 0 004.545-2.082A5 5 0 007 11zm11-3a3 3 0 11-6 0 3 3 0 016 0zm-2 5a5 5 0 00-4.545 2.918A9.953 9.953 0 0014 17a9.953 9.953 0 004.545-2.082A5 5 0 0016 11z" /></svg>
                    <span :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}" class="transition-opacity duration-200">Data Wali Murid</span>
                </a>
                <a href="{{ route('admin.attendances.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.attendances.*') ? 'bg-gray-900' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                    <span :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}" class="transition-opacity duration-200">Rekap Absensi</span>
                </a>
                 <a href="{{ route('admin.simulation.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.simulation.*') ? 'bg-gray-900' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" /></svg>
                    <span :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}" class="transition-opacity duration-200">Simulasi Absensi</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex justify-between items-center p-4 bg-white border-b">
                 <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <h1 class="text-2xl font-semibold text-gray-800 hidden lg:block">@yield('header', 'Dashboard')</h1>

                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block h-8 w-8 rounded-full overflow-hidden border-2 border-gray-600 focus:outline-none focus:border-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full object-cover" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0012 11z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20" x-cloak>
                        <div class="px-4 py-2 text-sm text-gray-700">
                            {{ Auth::user()->name }}
                        </div>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-500 hover:text-white">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                     <h1 class="text-2xl font-semibold text-gray-800 block lg:hidden mb-4">@yield('header', 'Dashboard')</h1>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>

