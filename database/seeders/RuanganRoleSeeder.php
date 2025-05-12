<?php

namespace Database\Seeders;

use App\Models\m_ruangan_role;
use Illuminate\Database\Seeder;

class RuanganRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangan_roles = [
            ['ruangan_role_nama' => 'Dosen'],
            ['ruangan_role_nama' => 'Ruang Teori'],
            ['ruangan_role_nama' => 'Lab Komputer'],
            ['ruangan_role_nama' => 'Auditorium'],
            ['ruangan_role_nama' => 'Ruang Administrasi'],
            ['ruangan_role_nama' => 'Lobby'],
            ['ruangan_role_nama' => 'Mushola'],
            ['ruangan_role_nama' => 'Umum'],
        ];

        foreach ($ruangan_roles as $ruangan_role) {
            m_ruangan_role::create($ruangan_role);
        }
    }
}
