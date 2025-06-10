<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_laporan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class DSSController extends Controller
{
    public function proses()
    {
        // convert to array
        $saw = $this->saw();
        $moora = $this->moora();

        return view('sarpras.proses_spk', [
            'saw' => $saw,
            'moora' => $moora,
        ]);
    }

    public function saw()
    {
        $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
            ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
            ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
            ->where('t_laporan.is_verified', 1)
            ->where('t_laporan.is_done', 0)
            ->where('spk_kerusakan', '!=', null)
            ->where('spk_dampak', '!=', null)
            ->where('spk_frekuensi', '!=', null)
            ->where('spk_waktu_perbaikan', '!=', null)
            ->where('teknisi_id', null)
            ->select(
                't_fasilitas_ruang.fasilitas_ruang_id',
                DB::raw('count(*) as jumlah_laporan'),
                DB::raw('MIN(t_laporan.lapor_datetime) as oldest_lapor_datetime'),
                'm_ruangan.ruangan_nama as ruangan_nama',
                'm_fasilitas.fasilitas_nama as fasilitas_nama',
                'spk_kerusakan',
                'spk_dampak',
                'spk_frekuensi',
                'spk_waktu_perbaikan'
            )
            ->groupBy(
                't_fasilitas_ruang.fasilitas_ruang_id',
                'm_ruangan.ruangan_nama',
                'm_fasilitas.fasilitas_nama',
                'spk_kerusakan',
                'spk_dampak',
                'spk_frekuensi',
                'spk_waktu_perbaikan'
            );

        // dd as array
        $data = $query->get()->toArray();

        $alternatif = [];

        $criteria = [
            1 => ['name' => 'Kerusakan', 'weight' => 0.25, 'type' => 'benefit'],
            2 => ['name' => 'Dampak', 'weight' => 0.2, 'type' => 'benefit'],
            3 => ['name' => 'Frekuensi', 'weight' => 0.2, 'type' => 'benefit'],
            4 => ['name' => 'Jumlah Pelapor', 'weight' => 0.15, 'type' => 'benefit'],
            5 => ['name' => 'Waktu Kerusakan', 'weight' => 0.1, 'type' => 'benefit'],
            6 => ['name' => 'Waktu Perbaikan', 'weight' => 0.1, 'type' => 'cost'],
        ];

        foreach ($data as $key => $value) {
            $kerusakan = $value['spk_kerusakan'];
            $dampak = $value['spk_dampak'];
            $frekuensi = $value['spk_frekuensi'];
            $jumlah_pelapor = 1;
            if ($value['jumlah_laporan'] > 50) {
                $jumlah_pelapor = 5;
            } else if ($value['jumlah_laporan'] <= 50 && $value['jumlah_laporan'] > 20) {
                $jumlah_pelapor = 4;
            } else if ($value['jumlah_laporan'] <= 20 && $value['jumlah_laporan'] > 10) {
                $jumlah_pelapor = 3;
            } else if ($value['jumlah_laporan'] <= 10 && $value['jumlah_laporan'] >= 5) {
                $jumlah_pelapor = 2;
            }

            $waktu_kerusakan = 1;
            // if waktu kerusakan lebih dari 14 hari maka waktu kerusakan = 2
            if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-14 days'))) {
                $waktu_kerusakan = 5;
            } else if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-5 days'))) {
                $waktu_kerusakan = 4;
            } else if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-2 days'))) {
                $waktu_kerusakan = 3;
            } else if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-1 days'))) {
                $waktu_kerusakan = 2;
            }

            $waktu_perbaikan = $value['spk_waktu_perbaikan'];

            $alternatif[$key + 1] = [
                'name' => $value['ruangan_nama'] . ' - ' . $value['fasilitas_nama'],
                'values' => [
                    $kerusakan,
                    $dampak,
                    $frekuensi,
                    $jumlah_pelapor,
                    $waktu_kerusakan,
                    $waktu_perbaikan
                ]
            ];
        }


        $maxMin = [];

        // ambil min max sesuai benefit atau cost
        foreach ($criteria as $key => $value) {
            $scoreCriteria = [];
            foreach ($alternatif as $alternative) {
                $scoreCriteria[] = $alternative['values'][$key - 1];
            }
            $max = max($scoreCriteria);
            $min = min($scoreCriteria);
            $maxMin[$key] = [
                'name' => $criteria[$key]['name'],
                'type' => $criteria[$key]['type'],
                'max' => $max,
                'min' => $min,
            ];
        }

        $original = $alternatif;

        // normalisasi
        foreach ($alternatif as $key => $value) {
            foreach ($value['values'] as $key2 => $value2) {
                if ($criteria[$key2 + 1]['type'] == 'benefit') {
                    $alternatif[$key]['values'][$key2] = $value2 / $maxMin[$key2 + 1]['max'];
                } else {
                    $alternatif[$key]['values'][$key2] = $maxMin[$key2 + 1]['min'] / $value2;
                }
            }
        }

        // hitung nilai preferensi
        $preferensi = [];
        foreach ($alternatif as $key => $value) {
            $preferensi[$key] = 0;
            foreach ($value['values'] as $key2 => $value2) {
                $preferensi[$key] += $value2 * $criteria[$key2 + 1]['weight'];
            }
        }

        $rank = [];
        foreach ($preferensi as $key => $value) {
            $ketAlt = [];
            if ($original[$key]['values'][0] == 5) {
                $ketAlt[] = 'Sangat Berat';
            } else if ($original[$key]['values'][0] == 4) {
                $ketAlt[] = 'Berat';
            } else if ($original[$key]['values'][0] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][0] == 2) {
                $ketAlt[] = 'Ringan';
            } else if ($original[$key]['values'][0] == 1) {
                $ketAlt[] = 'Sangat Ringan';
            }

            if ($original[$key]['values'][1] == 5) {
                $ketAlt[] = 'Sangat Tinggi';
            } else if ($original[$key]['values'][1] == 4) {
                $ketAlt[] = 'Tinggi';
            } else if ($original[$key]['values'][1] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][1] == 2) {
                $ketAlt[] = 'Rendah';
            } else if ($original[$key]['values'][1] == 1) {
                $ketAlt[] = 'Sangat Rendah';
            }

            if ($original[$key]['values'][2] == 5) {
                $ketAlt[] = 'Sangat Sering';
            } else if ($original[$key]['values'][2] == 4) {
                $ketAlt[] = 'Sering';
            } else if ($original[$key]['values'][2] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][2] == 2) {
                $ketAlt[] = 'Jarang';
            } else if ($original[$key]['values'][2] == 1) {
                $ketAlt[] = 'Sangat Jarang';
            }

            if ($original[$key]['values'][3] == 5) {
                $ketAlt[] = 'Sangat Banyak (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 4) {
                $ketAlt[] = 'Banyak (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 3) {
                $ketAlt[] = 'Sedang (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 2) {
                $ketAlt[] = 'Sedikit (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 1) {
                $ketAlt[] = 'Sangat Sedikit (' . $data[$key-1]['jumlah_laporan'] . ')';
            }

            if ($original[$key]['values'][4] == 5) {
                $ketAlt[] = 'Sangat Lama';
            } else if ($original[$key]['values'][4] == 4) {
                $ketAlt[] = 'Lama';
            } else if ($original[$key]['values'][4] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][4] == 2) {
                $ketAlt[] = 'Baru';
            } else if ($original[$key]['values'][4] == 1) {
                $ketAlt[] = 'Sangat Baru';
            }

            if ($original[$key]['values'][5] == 5) {
                $ketAlt[] = 'Bisa Ditunda';
            } else if ($original[$key]['values'][5] == 4) {
                $ketAlt[] = 'Tidak Terlalu Mendesak';
            } else if ($original[$key]['values'][5] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][5] == 2) {
                $ketAlt[] = 'Mendesak';
            } else if ($original[$key]['values'][5] == 1) {
                $ketAlt[] = 'Sangat Mendesak';
            }

            $rank[$key] = [
                'name' => $alternatif[$key]['name'],
                'alternatif' => $ketAlt,
                'value' => $value,
            ];
        }

        // Sort the rank array by value in descending order
        usort($rank, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });

        return [
            'criteria' => $criteria,
            'alternatif' => $original,
            'maxMin' => $maxMin,
            'normalisasi' => $alternatif,
            'preferensi' => $preferensi,
            'rank' => $rank,
        ];
    }

    public function moora()
    {
        $query = t_laporan::leftJoin('t_fasilitas_ruang', 't_laporan.fasilitas_ruang_id', '=', 't_fasilitas_ruang.fasilitas_ruang_id')
            ->leftJoin('m_ruangan', 't_fasilitas_ruang.ruangan_id', '=', 'm_ruangan.ruangan_id')
            ->leftJoin('m_fasilitas', 't_fasilitas_ruang.fasilitas_id', '=', 'm_fasilitas.fasilitas_id')
            ->where('t_laporan.is_verified', 1)
            ->where('t_laporan.is_done', 0)
            ->where('spk_kerusakan', '!=', null)
            ->where('spk_dampak', '!=', null)
            ->where('spk_frekuensi', '!=', null)
            ->where('spk_waktu_perbaikan', '!=', null)
            ->where('teknisi_id', null)
            ->select(
                't_fasilitas_ruang.fasilitas_ruang_id',
                DB::raw('count(*) as jumlah_laporan'),
                DB::raw('MIN(t_laporan.lapor_datetime) as oldest_lapor_datetime'),
                'm_ruangan.ruangan_nama as ruangan_nama',
                'm_fasilitas.fasilitas_nama as fasilitas_nama',
                'spk_kerusakan',
                'spk_dampak',
                'spk_frekuensi',
                'spk_waktu_perbaikan'
            )
            ->groupBy(
                't_fasilitas_ruang.fasilitas_ruang_id',
                'm_ruangan.ruangan_nama',
                'm_fasilitas.fasilitas_nama',
                'spk_kerusakan',
                'spk_dampak',
                'spk_frekuensi',
                'spk_waktu_perbaikan'
            );

        // dd as array
        $data = $query->get()->toArray();

        $alternatif = [];

        $criteria = [
            1 => ['name' => 'Kerusakan', 'weight' => 0.25, 'type' => 'benefit'],
            2 => ['name' => 'Dampak', 'weight' => 0.2, 'type' => 'benefit'],
            3 => ['name' => 'Frekuensi', 'weight' => 0.2, 'type' => 'benefit'],
            4 => ['name' => 'Jumlah Pelapor', 'weight' => 0.15, 'type' => 'benefit'],
            5 => ['name' => 'Waktu Kerusakan', 'weight' => 0.1, 'type' => 'benefit'],
            6 => ['name' => 'Waktu Perbaikan', 'weight' => 0.1, 'type' => 'cost'],
        ];

        // Log::info($data);

        foreach ($data as $key => $value) {
            $kerusakan = $value['spk_kerusakan'];
            $dampak = $value['spk_dampak'];
            $frekuensi = $value['spk_frekuensi'];
            $jumlah_pelapor = 1;
            if ($value['jumlah_laporan'] > 50) {
                $jumlah_pelapor = 5;
            } else if ($value['jumlah_laporan'] <= 50 && $value['jumlah_laporan'] > 20) {
                $jumlah_pelapor = 4;
            } else if ($value['jumlah_laporan'] <= 20 && $value['jumlah_laporan'] > 10) {
                $jumlah_pelapor = 3;
            } else if ($value['jumlah_laporan'] <= 10 && $value['jumlah_laporan'] >= 5) {
                $jumlah_pelapor = 2;
            }

            $waktu_kerusakan = 1;
            // if waktu kerusakan lebih dari 14 hari maka waktu kerusakan = 2
            if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-14 days'))) {
                $waktu_kerusakan = 5;
            } else if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-5 days'))) {
                $waktu_kerusakan = 4;
            } else if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-2 days'))) {
                $waktu_kerusakan = 3;
            } else if (date('Y-m-d', strtotime($value['oldest_lapor_datetime'])) > date('Y-m-d', strtotime('-1 days'))) {
                $waktu_kerusakan = 2;
            }

            $waktu_perbaikan = $value['spk_waktu_perbaikan'];

            $alternatif[$key + 1] = [
                'name' => $value['ruangan_nama'] . ' - ' . $value['fasilitas_nama'],
                'values' => [
                    $kerusakan,
                    $dampak,
                    $frekuensi,
                    $jumlah_pelapor,
                    $waktu_kerusakan,
                    $waktu_perbaikan
                ]
            ];
        }

        $sqrt = [];
        foreach ($criteria as $key => $value) {
            $score = 0;
            foreach ($alternatif as $alternative) {
                $score += $alternative['values'][$key - 1] ** 2;
            }
            $sqrt[$key] = sqrt($score);
        }

        $original = $alternatif;

        // normalisasi
        foreach ($alternatif as $key => $value) {
            foreach ($value['values'] as $key2 => $value2) {
                $alternatif[$key]['values'][$key2] = $value2 / $sqrt[$key2 + 1];
            }
        }

        // hitung nilai preferensi
        $preferensi = [];
        foreach ($alternatif as $key => $value) {
            $preferensi[$key] = 0;
            foreach ($value['values'] as $key2 => $value2) {
                if ($criteria[$key2 + 1]['type'] == 'benefit') {
                    $preferensi[$key] += $value2 * $criteria[$key2 + 1]['weight'];
                } else {
                    $preferensi[$key] -= $value2 * $criteria[$key2 + 1]['weight'];
                }
            }
        }

        $rank = [];
        foreach ($preferensi as $key => $value) {
            
            $ketAlt = [];
            if ($original[$key]['values'][0] == 5) {
                $ketAlt[] = 'Sangat Berat';
            } else if ($original[$key]['values'][0] == 4) {
                $ketAlt[] = 'Berat';
            } else if ($original[$key]['values'][0] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][0] == 2) {
                $ketAlt[] = 'Ringan';
            } else if ($original[$key]['values'][0] == 1) {
                $ketAlt[] = 'Sangat Ringan';
            }

            if ($original[$key]['values'][1] == 5) {
                $ketAlt[] = 'Sangat Tinggi';
            } else if ($original[$key]['values'][1] == 4) {
                $ketAlt[] = 'Tinggi';
            } else if ($original[$key]['values'][1] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][1] == 2) {
                $ketAlt[] = 'Rendah';
            } else if ($original[$key]['values'][1] == 1) {
                $ketAlt[] = 'Sangat Rendah';
            }

            if ($original[$key]['values'][2] == 5) {
                $ketAlt[] = 'Sangat Sering';
            } else if ($original[$key]['values'][2] == 4) {
                $ketAlt[] = 'Sering';
            } else if ($original[$key]['values'][2] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][2] == 2) {
                $ketAlt[] = 'Jarang';
            } else if ($original[$key]['values'][2] == 1) {
                $ketAlt[] = 'Sangat Jarang';
            }

            if ($original[$key]['values'][3] == 5) {
                $ketAlt[] = 'Sangat Banyak (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 4) {
                $ketAlt[] = 'Banyak (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 3) {
                $ketAlt[] = 'Sedang (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 2) {
                $ketAlt[] = 'Sedikit (' . $data[$key-1]['jumlah_laporan'] . ')';
            } else if ($original[$key]['values'][3] == 1) {
                $ketAlt[] = 'Sangat Sedikit (' . $data[$key-1]['jumlah_laporan'] . ')';
            }

            if ($original[$key]['values'][4] == 5) {
                $ketAlt[] = 'Sangat Lama';
            } else if ($original[$key]['values'][4] == 4) {
                $ketAlt[] = 'Lama';
            } else if ($original[$key]['values'][4] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][4] == 2) {
                $ketAlt[] = 'Baru';
            } else if ($original[$key]['values'][4] == 1) {
                $ketAlt[] = 'Sangat Baru';
            }

            if ($original[$key]['values'][5] == 5) {
                $ketAlt[] = 'Bisa Ditunda';
            } else if ($original[$key]['values'][5] == 4) {
                $ketAlt[] = 'Tidak Terlalu Mendesak';
            } else if ($original[$key]['values'][5] == 3) {
                $ketAlt[] = 'Sedang';
            } else if ($original[$key]['values'][5] == 2) {
                $ketAlt[] = 'Mendesak';
            } else if ($original[$key]['values'][5] == 1) {
                $ketAlt[] = 'Sangat Mendesak';
            }

            $rank[$key] = [
                'name' => $alternatif[$key]['name'],
                'alternatif' => $ketAlt,
                'value' => $value,
            ];
        }

        // Sort the rank array by value in descending order
        usort($rank, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });

        return [
            'sqrt' => $sqrt,
            'alternatif' => $original,
            'criteria' => $criteria,
            'preferensi' => $preferensi,
            'normalisasi' => $alternatif,
            'rank' => $rank,
        ];
    }
}
