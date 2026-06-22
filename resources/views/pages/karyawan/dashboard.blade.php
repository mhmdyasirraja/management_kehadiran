@extends('layouts.app')

@section('content')

@php
$user = Auth::guard('karyawan')->user();
$profil = $user->karyawan;
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                {{-- ✅ Pakai optional() biar aman kalau relasi karyawan null --}}
                <h1 class="text-2xl font-bold text-gray-800">
                    Selamat Datang, {{ optional($profil)->nama ?? $user->name ?? 'Karyawan' }}
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Pantau status kehadiran, riwayat absensi, dan informasi cuti Anda hari ini.
                </p>
            </div>

            <div class="text-sm text-gray-500">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Status Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status Hari Ini</p>
            <div class="mt-3 flex items-center justify-between">
                <h3 class="text-xl font-bold text-green-600">Hadir</h3>
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                    Aktif
                </span>
            </div>
        </div>

        {{-- Jam Masuk Terakhir --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jam Masuk Terakhir</p>
            <h3 class="text-xl font-bold text-gray-800 mt-3">08:05</h3>
        </div>

        {{-- Total Kehadiran --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Kehadiran</p>
            <h3 class="text-xl font-bold text-gray-800 mt-3">{{ $kehadiranBulanIni }} Hari</h3>
        </div>

        {{-- Sisa Cuti --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Izin Pending</p>
            <h3 class="text-xl font-bold text-blue-600 mt-3">{{ $izinPending }}</h3>
        </div>

    </div>

    {{-- Grid Konten --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Absensi Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Absensi Terbaru</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr class="text-left">
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Jam Masuk</th>
                            <th class="px-6 py-4 font-semibold">Jam Keluar</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        {{-- ✅ Pakai data dari controller --}}
                        @forelse($riwayat as $hadir)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($hadir->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">{{ $hadir->jam_check_in ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $hadir->jam_check_out ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($hadir->status === 'hadir')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Hadir</span>
                                @elseif($hadir->status === 'terlambat')
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">Terlambat</span>
                                @else
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">{{ $hadir->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada data absensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Panel Samping --}}
        <div class="space-y-6">

            {{-- Ringkasan Profil --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Profil</h2>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-medium text-gray-800">
                            {{-- ✅ Aman dari null --}}
                            {{ optional($profil)->nama ?? $user->name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Divisi</span>
                        <span class="font-medium text-gray-800">
                            {{ optional($profil)->divisi->nama ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium text-gray-800">
                            {{ $user->email ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Status</span>
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Aktif
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection