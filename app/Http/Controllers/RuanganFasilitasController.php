<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_ruangan as Ruangan;
use App\Models\m_fasilitas as Fasilitas;
use App\Models\t_fasilitas_ruang as FasilitasRuangan;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RuanganFasilitasController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        $fasilitas = Fasilitas::all();

        return view('admin.ruanganfasilitas.index', compact('ruangan', 'fasilitas'));
    }

    public function exportPdf()
    {
        $fasilitasRuanganRaw = FasilitasRuangan::with(['ruangan', 'fasilitas'])->get();

        $grouped = $fasilitasRuanganRaw->groupBy('ruangan_id');

        $fasilitasRuangan = [];
        $no = 1;

        foreach ($grouped as $group) {
            $ruangan = $group->first()->ruangan;
            $fasilitasNames = $group->pluck('fasilitas.fasilitas_nama')->filter()->join(', ');

            $fasilitasRuangan[] = [
                'no' => $no++,
                'ruangan_nama' => $ruangan->ruangan_nama ?? 'N/A',
                'jumlah_fasilitas' => $group->count(),
                'fasilitas_nama' => $fasilitasNames ?: 'Tidak ada fasilitas',
                'lantai' => $ruangan->lantai ?? 'N/A',
            ];
        }

        $pdf = Pdf::loadView('admin.ruanganfasilitas.pdf', compact('fasilitasRuangan'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-fasilitas-ruangan-' . date('Y-m-d') . '.pdf');
    }


    public function exportExcel()
    {
        $fasilitasRuanganRaw = FasilitasRuangan::with(['ruangan', 'fasilitas'])->get();

        $grouped = $fasilitasRuanganRaw->groupBy('ruangan_id');

        $no = 1;

        $fasilitasRuangan = $grouped->map(function ($group) use (&$no) {
            $ruangan = $group->first()->ruangan;
            $fasilitasNames = $group->pluck('fasilitas.fasilitas_nama')->filter()->join(', ');
            $jumlahFasilitas = $group->count();

            return [
                'no' => $no++,
                'ruangan_nama' => $ruangan->ruangan_nama ?? 'N/A',
                'jumlah_fasilitas' => $jumlahFasilitas,
                'fasilitas_nama' => $fasilitasNames ?: 'Tidak ada fasilitas',
                'lantai' => $ruangan->lantai ?? 'N/A',
            ];
        })->values();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Ruangan');
        $sheet->setCellValue('C1', 'Jumlah Fasilitas');
        $sheet->setCellValue('D1', 'Nama Fasilitas');
        $sheet->setCellValue('E1', 'Lantai');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $baris = 2;
        foreach ($fasilitasRuangan as $data) {
            $sheet->setCellValue('A' . $baris, $data['no']);
            $sheet->setCellValue('B' . $baris, $data['ruangan_nama']);
            $sheet->setCellValue('C' . $baris, $data['jumlah_fasilitas']);
            $sheet->setCellValue('D' . $baris, $data['fasilitas_nama']);
            $sheet->setCellValue('E' . $baris, $data['lantai']);
            $baris++;
        }

        foreach (range('A', 'E') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }

        $sheet->setTitle('Data Fasilitas Ruangan');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Fasilitas Ruangan - ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
}
