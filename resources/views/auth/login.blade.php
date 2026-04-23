<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AbsenKu</title>
    @vite('resources/css/app.css')

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md animate-fade-in">

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">

            {{-- Title --}}
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    Absen<span class="text-blue-600">Ku</span>
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Sistem Absensi Karyawan
                </p>
            </div>

            {{-- ALERT LOGIN GAGAL --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Email atau password yang Anda masukkan tidak sesuai.
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="Masukkan email"
                        oninvalid="this.setCustomValidity('Wajib mengisi email')"
                        oninput="this.setCustomValidity('')"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 focus:ring-red-500 @enderror"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            placeholder="Masukkan password"
                            oninvalid="this.setCustomValidity('Wajib mengisi password')"
                            oninput="this.setCustomValidity('')"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 focus:ring-red-500 @enderror"
                        >

                        {{-- Eye Button --}}
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7" />
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Button --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl text-sm font-medium hover:bg-blue-700 transition"
                >
                    Masuk
                </button>

            </form>

        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            © 2026 AbsenKu
        </p>

    </div>

    {{-- Script --}}
    <script>
        function togglePassword() {
            const input = document.getElementById('password');

            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>