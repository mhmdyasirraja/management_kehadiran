{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tom Select untuk dropdown search --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/css/tom-select.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.min.js"></script>

    <style>
        .ts-wrapper.single .ts-control {
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            padding: 0.5rem 1rem;
            min-height: 48px;
        }
        .ts-wrapper.single .ts-control:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        .ts-dropdown {
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            margin-top: 4px;
        }
        .ts-dropdown .option.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar')

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