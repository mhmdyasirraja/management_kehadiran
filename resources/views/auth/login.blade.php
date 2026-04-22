<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-4xl rounded-xl shadow flex overflow-hidden">

        {{-- LEFT --}}
        <div class="hidden md:flex w-1/2 bg-gray-50 p-10 flex-col justify-center">
            <h1 class="text-2xl font-bold mb-4">
                Absenku
            </h1>

            <p class="text-gray-600 text-sm mb-6">
                Kelola kehadiran karyawan dengan lebih mudah dan efisien.
            </p>

            <div class="flex gap-6 text-sm text-gray-500">
                <div>
                    <p class="font-semibold text-black">100%</p>
                    <p>Akurat</p>
                </div>
                <div>
                    <p class="font-semibold text-black">24/7</p>
                    <p>Realtime</p>
                </div>
                <div>
                    <p class="font-semibold text-black">Aman</p>
                    <p>Terjamin</p>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="w-full md:w-1/2 p-8 md:p-10">

            <h2 class="text-xl font-semibold mb-1">
                Login
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Masukkan email dan password
            </p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- EMAIL --}}
                <input type="email" name="email"
                    placeholder="Email"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">

                {{-- PASSWORD --}}
                <input type="password" name="password"
                    placeholder="Password"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">

                {{-- ACTION --}}
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="accent-black">
                        <span>Remember</span>
                    </label>

                    <a href="#" class="text-gray-500 hover:underline text-xs">
                        Lupa password?
                    </a>
                </div>

                {{-- BUTTON --}}
                <button
                    class="w-full bg-black text-white py-2 rounded text-sm hover:bg-gray-800 transition">
                    Masuk
                </button>

            </form>

        </div>

    </div>

</body>

</html>