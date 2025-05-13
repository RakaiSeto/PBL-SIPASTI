<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPASTI Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body {
            font-family: "Inter", sans-serif;
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
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 md:ml transition-all duration-300">
            @include('layouts.header')

            <div class="p-4">
                @include('layouts.breadcrumb')
                @yield('content')
            </div>

            @include('layouts.footer')
        </main>
    </div>
</body>

</html>