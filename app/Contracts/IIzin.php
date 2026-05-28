<?php
namespace App\Contracts;

interface IIzin {
    public function ajukanIzin(array $data);
    public function setujuIzin(int $id);
    public function tolakIzin(int $id);
    public function cekBatasHari(string $jenis): bool;
}