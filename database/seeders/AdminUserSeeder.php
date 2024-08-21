<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = User::firstOrCreate([
            'name' => 'Admin User',
            'user_name' => 'admin',
            'email' => 'admin@user.com',
            'passwotd' => Hash::make('Kosisochukwu@'),
            'account_type' => '',
            'user_name' => 'admin'
        ]);

        $admin_user->assignRole('admin');
    }
}
