<?php

namespace App\Http\Controllers;

use App\Models\m_ruangan;
use Illuminate\Http\Request;
use App\Models\m_ruangan_role as RoleRuangan;

use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class RuanganController extends Controller
{
    public function index()
    {
        $roleRuangan = RoleRuangan::all();

        return view('admin.ruangan.index', compact('roleRuangan'));
    }

    public function exportPDF()
    {
        $ruangan = m_ruangan::select('ruangan_role_id', 'ruangan_nama', 'lantai')
            ->orderBy('ruangan_nama')
            ->with('ruangan_role')
            ->get();

        $pdf = Pdf::loadView('admin.ruangan.export_pdf', ['ruangan' => $ruangan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->stream('Data Ruangan ' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function exportExcel()
    {
        $ruangan = m_ruangan::select('ruangan_role_id', 'ruangan_nama', 'lantai')
            ->orderBy('ruangan_nama')
            ->with('ruangan_role')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Jenis Ruangan');
        $sheet->setCellValue('C1', 'Nama Ruangan');
        $sheet->setCellValue('D1', 'Lantai');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $baris = 2;
        $no = 1;
        foreach ($ruangan as $data) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $data->ruangan_role->ruangan_role_nama ?? '-');
            $sheet->setCellValue('C' . $baris, $data->ruangan_nama);
            $sheet->setCellValue('D' . $baris, $data->lantai);

            $baris++;
            $no++;
        }

        foreach (range('A', 'D') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }

        $sheet->setTitle('Data Ruangan');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Ruangan - SIPASTI - ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

}
