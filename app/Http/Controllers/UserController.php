<?php

namespace App\Http\Controllers;

use App\Models\m_user;
use App\Models\m_role;

// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


class UserController extends Controller
{

    public function index()
    {
        $RolePengguna = m_role::all();

        return view('admin.datapengguna.index', compact('RolePengguna'));
    }
    public function exportPDF()
    {
        $pengguna = m_user::select('fullname', 'username', 'email', 'role_id')
            ->orderBy('fullname')
            ->with('role')
            ->get();

        $pdf = Pdf::loadView('admin.datapengguna.export_pdf', ['pengguna' => $pengguna]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->stream('Data Pengguna ' . date('Y-m-d H:i:s') . '.pdf');
    }


    public function exportExcel()
    {
        $pengguna = m_user::select('fullname', 'username', 'email', 'role_id')
            ->orderBy('fullname')
            ->with('role')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Role');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $baris = 2;
        $no = 1;
        foreach ($pengguna as $data) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $data->fullname);
            $sheet->setCellValue('C' . $baris, $data->username);
            $sheet->setCellValue('D' . $baris, $data->email);
            $sheet->setCellValue('E' . $baris, $data->role->role_nama ?? '-');

            $baris++;
            $no++;
        }

        foreach (range('A', 'E') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }

        $sheet->setTitle('Data Pengguna');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Pengguna - SIPASTI - ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
}