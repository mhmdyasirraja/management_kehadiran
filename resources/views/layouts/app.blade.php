<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar', ['role' => $role ?? null])

        {{-- Content --}}
        <main class="flex-1 p-8">
            <div class="w-full">

                {{-- Flash Messages --}}
                @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
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