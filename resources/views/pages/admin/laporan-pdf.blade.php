{{-- resources/views/pages/admin/laporan-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 4px; }
        p.subtitle { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 10px; text-align: left; }
        th { background-color: #f3f4f6; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; }
        .hadir { background: #dcfce7; color: #15803d; }
        .cuti { background: #fef9c3; color: #a16207; }
        .sakit { background: #dbeafe; color: #1d4ed8; }
        .alpha { background: #fee2e2; color: #b91c1c; }
    </style>
</head>
<body>
    <h2>Laporan Absensi Karyawan</h2>
    <p class="subtitle">Dicetak pada {{ now()->translatedFormat('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIP</th>
                <th>Nama Karyawan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->karyawan->nip ?? '-' }}</td>
                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                    <td>{{ $item->jam_masuk ?? '-' }}</td>
                    <td>{{ $item->jam_keluar ?? '-' }}</td>
                    <td><span class="badge {{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>