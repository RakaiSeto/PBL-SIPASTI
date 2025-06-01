<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class DSSController extends Controller
{
    public function saw()
    {
        $criteria = [
            1 => ['name' => 'Kerusakan', 'weight' => 0.25, 'type' => 'benefit'],
            2 => ['name' => 'Dampak', 'weight' => 0.2, 'type' => 'benefit'],
            3 => ['name' => 'Frekuensi', 'weight' => 0.2, 'type' => 'benefit'],
            4 => ['name' => 'Jumlah Pelapor', 'weight' => 0.15, 'type' => 'benefit'],
            5 => ['name' => 'Waktu Kerusakan', 'weight' => 0.1, 'type' => 'benefit'],
            6 => ['name' => 'Waktu Perbaikan', 'weight' => 0.1, 'type' => 'cost'],
        ];

        $alternatives = [
            1 => ['name' => 'Meja dan Kursi', 'values' => [5, 5, 3, 2, 4, 3]],
            2 => ['name' => 'Proyektor', 'values' => [4, 4, 3, 3, 3, 3]],
            3 => ['name' => 'Stop Kontak', 'values' => [4, 4, 4, 3, 3, 2]],
            4 => ['name' => 'AC', 'values' => [4, 3, 4, 4, 2, 4]],
            5 => ['name' => 'Toilet', 'values' => [3, 2, 5, 5, 5, 4]],
            6 => ['name' => 'Printer', 'values' => [3, 3, 2, 2, 2, 3]],
            7 => ['name' => 'Scanner', 'values' => [2, 2, 1, 1, 2, 2]],
        ];

        $maxMin = [];

        // ambil min max sesuai benefit atau cost
        foreach ($criteria as $key => $value) {
            $scoreCriteria = [];
            foreach ($alternatives as $alternative) {
                $scoreCriteria[] = $alternative['values'][$key - 1];
            }
            $maxMin[$key] = $value['type'] == 'benefit' ? max($scoreCriteria) : min($scoreCriteria);
        }

        // normalisasi
        foreach ($alternatives as $key => $value) {
            foreach ($value['values'] as $key2 => $value2) {
                if ($criteria[$key2 + 1]['type'] == 'benefit') {
                    $alternatives[$key]['values'][$key2] = $value2 / $maxMin[$key2 + 1];
                } else {
                    $alternatives[$key]['values'][$key2] = $maxMin[$key2 + 1] / $value2;
                }
            }
        }

        // hitung nilai preferensi
        $preferensi = [];
        foreach ($alternatives as $key => $value) {
            $preferensi[$key] = 0;
            foreach ($value['values'] as $key2 => $value2) {
                $preferensi[$key] += $value2 * $criteria[$key2 + 1]['weight'];
            }
        }

        $rank = [];
        foreach ($preferensi as $key => $value) {
            $rank[$key] = [
                'name' => $alternatives[$key]['name'],
                'value' => $value,
            ];
        }

        // Sort the rank array by value in descending order
        usort($rank, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });

        return response()->json([
            'rank' => $rank,
        ]);
    }

    public function moora()
    {
        $criteria = [
            1 => ['name' => 'Kerusakan', 'weight' => 0.25, 'type' => 'benefit'],
            2 => ['name' => 'Dampak', 'weight' => 0.2, 'type' => 'benefit'],
            3 => ['name' => 'Frekuensi', 'weight' => 0.2, 'type' => 'benefit'],
            4 => ['name' => 'Jumlah Pelapor', 'weight' => 0.15, 'type' => 'benefit'],
            5 => ['name' => 'Waktu Kerusakan', 'weight' => 0.1, 'type' => 'benefit'],
            6 => ['name' => 'Waktu Perbaikan', 'weight' => 0.1, 'type' => 'cost'],
        ];

        $alternatives = [
            1 => ['name' => 'Meja dan Kursi', 'values' => [5, 5, 3, 2, 4, 3]],
            2 => ['name' => 'Proyektor', 'values' => [4, 4, 3, 3, 3, 3]],
            3 => ['name' => 'Stop Kontak', 'values' => [4, 4, 4, 3, 3, 2]],
            4 => ['name' => 'AC', 'values' => [4, 3, 4, 4, 2, 4]],
            5 => ['name' => 'Toilet', 'values' => [3, 2, 5, 5, 5, 4]],
            6 => ['name' => 'Printer', 'values' => [3, 3, 2, 2, 2, 3]],
            7 => ['name' => 'Scanner', 'values' => [2, 2, 1, 1, 2, 2]],
        ];

        $sqrt = [];
        foreach ($criteria as $key => $value) {
            $score = 0;
            foreach ($alternatives as $alternative) {
                $score += $alternative['values'][$key - 1] ** 2;
            }
            $sqrt[$key] = sqrt($score);
        }

        // normalisasi
        foreach ($alternatives as $key => $value) {
            foreach ($value['values'] as $key2 => $value2) {
                $alternatives[$key]['values'][$key2] = $value2 / $sqrt[$key2 + 1];
            }
        }

        // hitung nilai preferensi
        $preferensi = [];
        foreach ($alternatives as $key => $value) {
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
            $rank[$key] = [
                'name' => $alternatives[$key]['name'],
                'value' => $value,
            ];
        }

        // Sort the rank array by value in descending order
        usort($rank, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });

        return response()->json([
            'rank' => $rank,
        ]);
    }
}
