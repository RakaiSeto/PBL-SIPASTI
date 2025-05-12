<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\m_role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_nama' => 'Admin'],
            ['role_nama' => 'Sarpras'],
            ['role_nama' => 'Teknisi'],
            ['role_nama' => 'Civitas'],
        ];

        foreach ($roles as $role) {
            m_role::create($role);
        }
    }
}
