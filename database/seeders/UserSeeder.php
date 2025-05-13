<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\m_user;
use Illuminate\Support\Facades\Hash;
use App\Models\m_role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        m_user::create([
            'role_id' => m_role::where('role_nama', 'Admin')->first()->role_id,
            'username' => 'admin',
            'fullname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('sipasti123'),
        ]);
    }
}
