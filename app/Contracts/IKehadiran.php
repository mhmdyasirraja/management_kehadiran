<?php
namespace App\Contracts;

interface IKehadiran
{
    public function checkIn($karyawan, float $latitude, float $longitude): array;

    public function checkOut($karyawan, float $latitude, float $longitude): array;

    public function riwayat($karyawan);
}
