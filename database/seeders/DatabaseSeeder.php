<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('m_fasilitas')->delete();
        DB::table('m_ruangan_role')->delete();
        DB::table('m_role')->delete();

        $this->call([
            RoleSeeder::class,
            RuanganRoleSeeder::class,
            FasilitasSeeder::class,
        ]);
    }
}
