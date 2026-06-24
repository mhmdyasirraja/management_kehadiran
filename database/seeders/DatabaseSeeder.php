<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Membuat data divisi contoh menggunakan nama kolom 'nama'
        Divisi::create(['nama' => 'IT Support']);
        Divisi::create(['nama' => 'Human Resource (HR)']);
        Divisi::create(['nama' => 'Finance']);
        Divisi::create(['nama' => 'Marketing']);

        // 2. Membuat akun admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
        ]);
    }
}