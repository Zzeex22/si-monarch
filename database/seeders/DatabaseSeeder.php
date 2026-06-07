<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin (Eksekutif Proyek)
        User::create([
            'name' => 'Hidayat Qodri Tarigan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Passwordnya ini ya lek
            'role' => 'admin',
        ]);

        // 2. Buat Akun Direktur (Pemantau & Approver)
        User::create([
            'name' => 'Pak Direktur',
            'email' => 'direktur@gmail.com',
            'password' => Hash::make('password123'), // Passwordnya sama biar gampang
            'role' => 'direktur',
        ]);
    }
}