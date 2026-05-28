<?php
namespace App\Contracts;

interface IKehadiran {
    public function checkIn(string $lokasi);
    public function checkOut(string $lokasi);
    public function validasiLokasi(string $lokasi): bool;
    public function getRekapKehadiran();
}