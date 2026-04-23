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