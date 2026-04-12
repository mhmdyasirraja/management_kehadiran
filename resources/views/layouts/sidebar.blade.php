<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col p-5">

            <!-- LOGO -->
            <div class="flex items-center gap-2 mb-8">
                <span class="font-semibold text-gray-800 text-lg">Karyawan App</span>
            </div>

            <!-- MENU -->
            <nav class="flex flex-col gap-2 text-sm">

                @if(($role ?? '') === 'admin')

                <a href="{{ url('/admin/dashboard') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Dashboard
                </a>

                <a href="{{ url('/admin/divisi') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('admin/divisi*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Management Divisi
                </a>

                <a href="{{ url('/admin/karyawan') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('admin/karyawan*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Management Karyawan
                </a>

                <a href="{{ url('/admin/approval') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('admin/approval*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Perizinan
                </a>

                <a href="{{ url('/admin/laporan') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('admin/laporan*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Laporan
                </a>

                <a href="{{ url('/admin/pengaturan') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('admin/pengaturan*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Pengaturan
                </a>

                @elseif(($role ?? '') === 'karyawan')

                <a href="{{ url('/karyawan/dashboard') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('karyawan/dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Dashboard
                </a>

                <a href="{{ url('/karyawan/absensi') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('karyawan/absensi*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Absensi
                </a>

                <a href="{{ url('/karyawan/perizinan') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('karyawan/perizinan*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Perizinan
                </a>

                <a href="{{ url('/karyawan/riwayat') }}"
                    class="px-3 py-2 rounded-lg {{ request()->is('karyawan/riwayat*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Riwayat
                </a>

                @endif

            </nav>

            <!-- BOTTOM -->
            <div class="mt-auto pt-6 border-t border-gray-200">
                <a href="/logout"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <span>Logout</span>
                </a>
            </div>

        </aside>

        <!-- CONTENT -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>
    <script>
        function openModal(id) {
            const modal = document.getElementById(id)
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden')
        }
    </script>
</body>

</html>