@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="space-y-6">

    {{-- HEADER --}}
    @include('components.header_card', [
    'title' => 'Absensi Karyawan',
    'subtitle' => now()->format('l, d F Y')
    ])

    {{-- ABSENSI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm flex justify-between items-center">

        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                {{ now()->format('d F Y | H:i') }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
    Status:

    @if($sudahCheckOut)
        <span class="text-blue-600 font-medium">
            Sudah Check Out
        </span>
    @elseif($sudahCheckIn)
        <span class="text-green-600 font-medium">
            Sudah Check In
        </span>
    @else
        <span class="text-yellow-600 font-medium">
            Belum Check In
        </span>
    @endif

</p>

        </div>

        @if(!$sudahCheckIn)

<form action="/karyawan/checkin" method="POST">
    @csrf
    <button
        type="submit"
        class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600">
        Check In
    </button>
</form>

@elseif(!$sudahCheckOut)

<form action="/karyawan/checkout" method="POST">
    @csrf
    <button
        type="submit"
        class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">
        Check Out
    </button>
</form>

@else

<div class="text-green-600 font-semibold">
    Absensi Hari Ini Selesai
</div>

@endif


    </div>

    {{-- RIWAYAT --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Riwayat Absensi
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-600">

                <thead class="border-b text-gray-500 text-left">
                    <tr>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Jam Masuk</th>
                        <th class="py-3">Jam Keluar</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

            @forelse($riwayat as $item)
<tr class="hover:bg-gray-50">

    <td class="py-3">
        {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
    </td>

    <td class="py-3">
        {{ $item->jam_masuk ?? '-' }}
    </td>

    <td class="py-3">
        {{ $item->jam_keluar ?? '-' }}
    </td>

    <td class="py-3">
        @if($item->status == 'hadir')
            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                Hadir
            </span>
        @elseif($item->status == 'izin')
            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">
                Izin
            </span>
        @elseif($item->status == 'sakit')
            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                Sakit
            </span>
        @else
            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                {{ ucfirst($item->status) }}
            </span>
        @endif
    </td>

</tr>
@empty

<tr>
    <td colspan="4" class="py-4 text-center text-gray-500">
        Belum ada riwayat absensi
    </td>
</tr>

@endforelse
</tbody>
</table>
</div>
</div>
</div>

@endsection
