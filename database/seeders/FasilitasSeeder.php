<?php

namespace Database\Seeders;

use App\Models\m_fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitas = [
            ['fasilitas_nama' => 'AC'],
            ['fasilitas_nama' => 'Projector'],
            ['fasilitas_nama' => 'Kelistrikan'],
            ['fasilitas_nama' => 'Meja'],
            ['fasilitas_nama' => 'Kursi'],
            ['fasilitas_nama' => 'WiFi'],
            ['fasilitas_nama' => 'Printer'],
            ['fasilitas_nama' => 'Komputer'],
            ['fasilitas_nama' => 'Scanner'],
            ['fasilitas_nama' => 'Dispenser'],
            ['fasilitas_nama' => 'Wastafel'],
            ['fasilitas_nama' => 'Bilik Toilet'],
            ['fasilitas_nama' => 'Tong Sampah'],
            ['fasilitas_nama' => 'Pintu'],
        ];

        foreach ($fasilitas as $f) {
            m_fasilitas::create($f);
        }
    }
}
