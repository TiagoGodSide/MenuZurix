<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@menupro.com',
            ],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
            ]
        );
        $this->call(BusinessSeeder::class);
    }
}