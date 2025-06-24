<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_role;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RoleController extends Controller
{
    public function exportPDF()
{
    $roles = m_role::select('role_nama')->orderBy('role_nama')->get();

    $pdf = Pdf::loadView('admin.datarole.export_pdf', ['roles' => $roles]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption('isRemoteEnabled', true);

    return $pdf->stream('Data Role ' . date('Y-m-d H:i:s') . '.pdf');
}



    public function exportExcel()
{
    $roles = m_role::select('role_nama')->orderBy('role_nama')->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Role');
    $sheet->getStyle('A1:B1')->getFont()->setBold(true);

    $baris = 2;
    $no = 1;
    foreach ($roles as $role) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $role->role_nama);
        $baris++;
        $no++;
    }

    foreach (range('A', 'B') as $kolom) {
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
    }

    $sheet->setTitle('Data Role');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Role - SIPASTI - ' . date('Y-m-d H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$filename}\"");
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $writer->save('php://output');
    exit;
}

}