<?php

namespace App\Http\Controllers;

use App\Models\m_ruangan_role;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;



class RoleRuanganController extends Controller
{
    public function exportPDF()
    {
        $pengguna = m_ruangan_role::select('ruangan_role_nama')
            ->orderBy('ruangan_role_nama')
            ->get();

        $pdf = Pdf::loadView('admin.roleruangan.export_pdf', ['pengguna' => $pengguna]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->stream('Data Role Ruangan ' . date('Y-m-d H:i:s') . '.pdf');
    }


    public function exportExcel(){
        $pengguna = m_ruangan_role::select('ruangan_role_nama')
                ->orderBy('ruangan_role_nama')
                ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Role Ruangan');

        $sheet->getStyle('A1:B1')->getFont()->setBold(true);

        $baris = 2;
        $no = 1;
        foreach ($pengguna as $data) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $data->ruangan_role_nama);

            $baris++;
            $no++;
        }

        foreach (range('A', 'B') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }

        $sheet->setTitle('Data Role Ruangan');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Role Ruangan - SIPASTI - ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
}