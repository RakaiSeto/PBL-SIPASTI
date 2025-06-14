<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px 4px;
            font-size: 11pt;
        }

        .header-table td {
            border: none;
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

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .border-bottom-header {
            border-bottom: 1px solid black;
        }

        .fasilitas-column {
            max-width: 200px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>

    <!-- Kop Surat -->
    <table class="header-table border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('assets/image/polinema-bw.jpeg') }}" class="image">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN
                    TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341)
                    404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center" style="margin: 20px 0;">LAPORAN DATA FASILITAS RUANGAN</h3>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 25%;">Ruangan</th>
                <th class="text-center" style="width: 15%;">Jumlah Fasilitas</th>
                <th style="width: 40%;">Nama Fasilitas</th>
                <th class="text-center" style="width: 15%;">Lantai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fasilitasRuangan as $item)
                <tr>
                    <td class="text-center">{{ $item['no'] }}</td>
                    <td>{{ $item['ruangan_nama'] }}</td>
                    <td class="text-center">{{ $item['jumlah_fasilitas'] }}</td>
                    <td class="fasilitas-column">{{ $item['fasilitas_nama'] }}</td>
                    <td class="text-center">{{ $item['lantai'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
