<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 1.5;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 11pt;
        }
        /* Tabel header kop surat tanpa border */
        .header-table td {
            border: none;
            vertical-align: middle;
        }
        /* Tabel ringkasan tanpa border */
        .summary-table td {
            border: none;
            padding: 4px 8px;
            font-size: 11pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .d-block {
            display: block;
        }
        .image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }
        .font-bold {
            font-weight: bold;
        }
        .font-10 { font-size: 10pt; }
        .font-11 { font-size: 11pt; }
        .font-12 { font-size: 12pt; }
        .font-13 { font-size: 13pt; }
        .mb-1 { margin-bottom: 4px; }
        .border-bottom-header {
            border-bottom: 1px solid black;
        }
        h4 {
            margin-bottom: 8px;
            margin-top: 24px;
            font-size: 13pt;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-top: 24px;
            margin-bottom: 24px;
            text-transform: uppercase;
        }
        p {
            font-size: 11pt;
            margin-top: 0;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="header-table border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('assets/image/polinema-bw.jpeg') }}" alt="Logo Polinema" class="image">
            </td>
            <td width="85%" class="text-center">
                <span class="d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span class="d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <div class="title">Laporan Statistik Sarana Prasarana  {{ $tahun }}</div>

    <!-- Ringkasan Statistik (tanpa border tabel) -->
    <h4>Ringkasan Statistik</h4>
   <table class="summary-table">
    <tbody>
        <tr>
            <td style="text-align:left;">Total Laporan</td>
            <td style="text-align:right;">{{ $totalLaporan }}</td>
        </tr>
        <tr>
            <td style="text-align:left;">Laporan Dalam Proses</td>
            <td style="text-align:right;">{{ $totalLaporanProses }}</td>
        </tr>
        <tr>
            <td style="text-align:left;">Laporan Selesai</td>
            <td style="text-align:right;">{{ $totalLaporanSelesai }}</td>
        </tr>
        <tr>
            <td style="text-align:left;">Laporan Ditolak</td>
            <td style="text-align:right;">{{ $totalLaporanDitolak }}</td>
        </tr>
        <tr>
            <td style="text-align:left;">Kepuasan Pengguna</td>
            <td style="text-align:right;">{{ round($rataKepuasan * 20) }}%</td>
        </tr>
    </tbody>
</table>

    <!-- Jumlah Laporan per Bulan -->
    <h4>Jumlah Laporan Kerusakan Per Tahun</h4>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Laporan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulanLaporan as $index => $bulan)
            <tr>
                <td>{{ $bulan }}</td>
                <td class="text-right">{{ $jumlahLaporan[$index] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Kerusakan Fasilitas -->
    <h4>Kerusakan Fasilitas Terbanyak</h4>
    <table>
        <thead>
            <tr>
                <th>Nama Fasilitas</th>
                <th>Jumlah Kerusakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kerusakanFasilitas as $nama_fasilitas => $jumlah)
            <tr>
                <td>{{ $nama_fasilitas }}</td>
                <td class="text-right">{{ $jumlah }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Kerusakan Terbanyak di Ruangan -->
    <h4>Laporan Kerusakan Terbanyak</h4>
    <table>
        <thead>
            <tr>
                <th>Ruangan</th>
                <th>Fasilitas</th>
                <th>Jumlah Laporan</th>
                <th>Terakhir Dilaporkan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kerusakanRuangan as $kr)
            <tr>
                <td>{{ $kr['ruangan'] }}</td>
                <td>{{ $kr['fasilitas'] }}</td>
                <td class="text-right">{{ $kr['jumlah_laporan'] }}</td>
                <td>{{ \Carbon\Carbon::parse($kr['terakhir_dilaporkan'])->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Detail Laporan Kerusakan</h4>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelapor</th>
            <th>Ruangan</th>
            <th>Fasilitas</th>
            <th>Tanggal Pelaporan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detailKerusakanRuangan as $i => $detail)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $detail['nama_pelapor'] }}</td>
            <td>{{ $detail['ruangan_nama'] }}</td>
            <td>{{ $detail['fasilitas_nama'] }}</td>
            <td>{{ \Carbon\Carbon::parse($detail['tanggal_pelaporan'])->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
