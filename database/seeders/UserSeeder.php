<?php

namespace Database\Seeders;

// Artisan: php artisan make:seeder UserSeeder
// Path: database/seeders/UserSeeder.php
// Jalankan: php artisan db:seed --class=UserSeeder

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed akun admin dan staff untuk Pustu.
     */
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@pustu.test'],
            [
                'name'      => 'Administrator Pustu',
                'email'     => 'admin@pustu.test',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Akun Staff
        User::updateOrCreate(
            ['email' => 'staff@pustu.test'],
            [
                'name'      => 'Staff Pustu',
                'email'     => 'staff@pustu.test',
                'password'  => Hash::make('staff123'),
                'role'      => 'staff',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ User admin & staff berhasil dibuat!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@pustu.test', 'admin123'],
                ['Staff', 'staff@pustu.test', 'staff123'],
            ]
        );
    }
}
