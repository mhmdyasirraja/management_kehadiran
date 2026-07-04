<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Nama Karyawan', 'Tanggal', 'Jam Masuk', 'Jam Keluar', 'Status', 'Keterangan'];
    }

    public function map($item): array
    {
        return [
            $item->karyawan->nama ?? '-',
            \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
            $item->jam_masuk ?? '-',
            $item->jam_keluar ?? '-',
            ucfirst($item->status),
            $item->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}