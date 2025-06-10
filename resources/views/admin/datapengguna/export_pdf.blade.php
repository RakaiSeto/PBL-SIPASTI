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
                border: 1px solid;
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
                    <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET,
                        DAN TEKNOLOGI</span>
                    <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                    <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                    <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax.
                        (0341) 404420</span>
                    <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
                </td>
            </tr>
        </table>

        <h3 class="text-center" style="margin: 20px 0;">LAPORAN DATA PENGGUNA</h3>

        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengguna as $index => $user)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->role_nama ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </body>

    </html>
