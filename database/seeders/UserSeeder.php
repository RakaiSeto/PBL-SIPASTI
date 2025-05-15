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
        m_user::create([
            'role_id' => m_role::where('role_nama', 'Civitas')->first()->role_id,
            'username' => 'civitas',
            'fullname' => 'Civitas',
            'email' => 'civitas@civitas.com',
            'password' => Hash::make('sipasti123'),
        ]);
        m_user::create([
            'role_id' => m_role::where('role_nama', 'Teknisi')->first()->role_id,
            'username' => 'teknisi',
            'fullname' => 'Teknisi',
            'email' => 'teknisi@teknisi.com',
            'password' => Hash::make('sipasti123'),
        ]);
        m_user::create([
            'role_id' => m_role::where('role_nama', 'Sarpras')->first()->role_id,
            'username' => 'sarpras',
            'fullname' => 'Sarpras',
            'email' => 'sarpras@sarpras.com',
            'password' => Hash::make('sipasti123'),
        ]);
    }
}
