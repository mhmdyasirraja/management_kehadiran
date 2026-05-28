<?php
namespace App\Contracts;

interface IAuth {
    public function login(string $email, string $password);
    public function logout();
    public function cekHakAkses(string $menu): bool;
}