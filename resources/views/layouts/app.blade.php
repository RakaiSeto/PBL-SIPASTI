<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPASTI Dashboard</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (wajib untuk Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
        body {
            /* font-family: 'Comic Neue', cursive; */
font-family: "Poppins", sans-serif;

            /* font-family: "Poppins", sans-serif; */
        }

        :root {
            --primary: #1652b7;
            --primary-hover: #1f3f97;
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-primary:hover {
            background-color: var(--primary-hover);
        }
        #sidebar.show {
            display: block !important;
        }
.btn-primary {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
}

.btn-batal {
    background-color: #d1d5db; /
    color: #1f2937;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-batal:hover {
    background-color: #9ca3af;
}


.btn-hapus {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-hapus:hover {
    background-color: #c82333;
}

.dataTables_length {
    margin-bottom: 1rem;
}

table.dataTable tbody td,
table.dataTable thead th {
 border-top: 1px solid #f8fafc; /* garis horizontal atas */
    border-bottom: 1px solid #f8fafc; /* garis horizontal bawah */
    border-left: none;  /* hilangkan garis vertikal kiri */
    border-right: none;
    overflow: hidden;
}

    </style>
</head>

<body class="bg-gray-100 ">
    <div class="flex min-h-screen overflow-x-hidden">
        @include('layouts.sidebar')

        <main class="flex-1 ml-0 md:ml-64 transition-all duration-300 min-w-0">
        {{-- <main class="flex-1 ml-64 overflow-y-auto max-h-screen"> --}}

        {{-- <main class="flex-1 md:ml transition-all duration-300"> --}}
            @include('layouts.header')

            <div class="p-4">
                @include('layouts.breadcrumb')
                @yield('content')
            </div>

            @include('layouts.footer')
        </main>
    </div>
    @filamentScripts
</body>

</html>
