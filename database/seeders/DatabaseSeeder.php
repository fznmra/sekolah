<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // Cek jika user sudah ada, jika belum baru buat
        // Admin
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'), // Password akan di-encrypt
            'role'     => 'admin',
        ]);

        // Guru
        User::create([
            'username' => 'guru1',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
        ]);

        // Orang Tua
        User::create([
            'username' => 'ortu1',
            'password' => Hash::make('ortu123'),
            'role'     => 'orang_tua',
        ]);
    }
}