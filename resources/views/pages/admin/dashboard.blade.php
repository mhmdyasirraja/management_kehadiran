@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    @include('components.header_card', [
    'title' => 'SELAMAT DATANG, ADMIN',
    'subtitle' => now()->format('l, d F Y')
    ])

    

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- DONUT CHART — Status Hari Ini --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Status Kehadiran</h2>
            <p class="text-xs text-gray-400 mb-4">Hari ini</p>
            <div class="flex-1 flex items-center justify-center">
                <div class="relative w-48 h-48">
                    <canvas id="donutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-gray-800">{{ $totalKaryawan }}</span>
                        <span class="text-xs text-gray-400">Karyawan</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-2 text-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                        <span class="text-gray-600">Hadir</span>
                    </div>
                    <span class="font-semibold text-gray-800">{{ $hadirHariIni }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>
                        <span class="text-gray-600">Izin / Cuti</span>
                    </div>
                    <span class="font-semibold text-gray-800">{{ $izinHariIni }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                        <span class="text-gray-600">Tidak Hadir</span>
                    </div>
                    <span class="font-semibold text-gray-800">{{ $tidakHadir }}</span>
                </div>
            </div>
        </div>

        {{-- BAR CHART — Tren 7 Hari Terakhir --}}
        <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2 flex flex-col">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Tren Kehadiran</h2>
            <p class="text-xs text-gray-400 mb-4">7 hari terakhir</p>
            <div class="flex-1 min-h-0">
                <canvas id="barChart" class="w-full" style="max-height: 220px;"></canvas>
            </div>
            <div class="mt-4 flex flex-wrap gap-4 text-xs text-gray-500">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-green-500 inline-block"></span> Hadir
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-yellow-400 inline-block"></span> Izin
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span> Tidak Hadir
                </div>
            </div>
        </div>

    </div>

    {{-- TABEL ABSENSI TERBARU --}}
    <div class="bg-white rounded-xl shadow-sm p-6">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Absensi Terbaru</h2>
        <a href="{{ url('/admin/laporan') }}" class="text-sm text-blue-600 hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">

            <thead class="text-gray-500 border-b text-xs uppercase">
                <tr>
                    <th class="py-3 pr-4">No</th>
                    <th class="py-3 pr-4">Nama</th>
                    <th class="py-3 text-center">Tanggal</th>
                    <th class="py-3 text-center">Masuk</th>
                    <th class="py-3 text-center">Keluar</th>
                    <th class="py-3 text-center">Status</th>
                </tr>
            </thead>

            <tbody class="text-gray-700 divide-y divide-gray-100">

                @forelse ($absensiTerbaru as $index => $absen)

                <tr class="hover:bg-slate-50 transition duration-200">

                    <td class="py-4 px-4 text-gray-400 font-medium">
                        {{ $index + 1 }}
                    </td>

                    <td class="py-4 px-4">

                        <div class="flex items-center gap-3">

                            {{-- Avatar --}}
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-semibold flex items-center justify-center">
                                {{ strtoupper(substr($absen->karyawan->nama ?? '-',0,1)) }}
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $absen->karyawan->nama ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    Karyawan
                                </p>
                            </div>

                        </div>

                    </td>

                    <td class="py-4 px-4 text-center text-gray-500">
                        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}
                    </td>

                    <td class="py-4 px-4 text-center font-medium text-gray-700">
                        {{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '—' }}
                    </td>

                    <td class="py-4 px-4 text-center font-medium text-gray-700">
                        {{ $absen->jam_keluar ? \Carbon\Carbon::parse($absen->jam_keluar)->format('H:i') : '—' }}
                    </td>

                    <td class="py-4 px-4 text-center">

                        @php
                            $st = strtolower($absen->status);
                        @endphp

                        @if($st == 'hadir')

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                Hadir
                            </span>

                        @elseif($st == 'izin')

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                Izin
                            </span>

                        @elseif($st == 'terlambat')

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                Terlambat
                            </span>

                        @else

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                Tidak Hadir
                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="py-10 text-center text-gray-400">
                        Belum ada data absensi.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

{{-- Data dari PHP --}}
<script>
    const donutData = @json($donutData);
    const barLabels = @json($barLabels);
    const barHadir = @json($barHadir);
    const barIzin = @json($barIzin);
    const barTidakHadir = @json($barTidakHadir);
</script>

@verbatim
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ─── DONUT CHART ───────────────────────────────────────────
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Izin / Cuti', 'Tidak Hadir'],
                datasets: [{
                    data: donutData,
                    backgroundColor: ['#22c55e', '#facc15', '#f87171'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ' ' + ctx.label + ': ' + ctx.raw + ' orang';
                            }
                        }
                    }
                }
            }
        });

        // ─── BAR CHART ─────────────────────────────────────────────
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                        label: 'Hadir',
                        data: barHadir,
                        backgroundColor: '#22c55e',
                        borderRadius: 4,
                    },
                    {
                        label: 'Izin',
                        data: barIzin,
                        backgroundColor: '#facc15',
                        borderRadius: 4,
                    },
                    {
                        label: 'Tidak Hadir',
                        data: barTidakHadir,
                        backgroundColor: '#f87171',
                        borderRadius: 4,
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            },
                            stepSize: 1,
                        },
                        grid: {
                            color: '#f3f4f6'
                        }
                    }
                }
            }
        });

    });
</script>
@endverbatim

@endsection