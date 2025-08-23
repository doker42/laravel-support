<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_DEFAULT_EMAIL', 'admin@mail.com');
        $admin = User::where('email', $adminEmail)->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => env('ADMIN_DEFAULT_EMAIL', 'admin@mail.com'),
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'demo1234')),
            ]);
        }
    }
}
