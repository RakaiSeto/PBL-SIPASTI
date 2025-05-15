<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - SIPASTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/x-icon">

    @vite('resources/css/app.css', 'resources/js/app.js')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm bg-white rounded-xl shadow-md p-8">
        <div class="flex flex-col items-center mb-1">
            <a href="/">
                <img src="{{ asset('assets/image/sipasti.svg') }}" alt="Logo SIPASTI" class="h-12 mb-2">
            </a>
            <div class="w-full border-t-2 border-[#1652B7] mt-1 mb-4"></div>
            <p class="text-sm text-center text-gray-600">Register new account</p>
        </div>

        <form method="POST" action="#" class="space-y-8 mt-1">
            @csrf

            <select name="level" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option selected disabled>Pilih Level</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="tendik">Tenaga Kependidikan</option>
                <option value="sarpras">Sarana Prasarana</option>
                <option value="teknisi">Teknisi</option>
            </select>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-user text-gray-400"></i>
                </div>
                <input type="text" name="username" id="username" class="block w-full pl-10 border-b-2 border-gray-300 focus:outline-none focus:border-b-blue-500" placeholder="Username">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-id-card text-gray-400"></i>
                </div>
                <input type="text" name="nama" id="nama" class="block w-full pl-10 pr-10 border-b-2 border-gray-300 focus:outline-none focus:border-b-blue-500" placeholder="Nama">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-lock text-gray-400"></i>
                </div>
                <input type="password" name="password" id="password" class="block w-full pl-10 pr-10 border-b-2 border-gray-300 focus:outline-none focus:border-b-blue-500" placeholder="Password">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400" id="togglePassword">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </div>
            </div>

            <button type="submit" class="w-full py-2 rounded-md bg-[#1652B7] text-white font-semibold hover:bg-[#143f8a] transition mt-8">
                REGISTER
            </button>
        </form>

        <p class="mt-4 text-sm text-gray-600">
            Sudah punya akun? <a href="{{ url('/login') }}" class="text-blue-600 hover:underline">Login disini</a>
        </p>
    </div>
</body>
<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    toggle.addEventListener('click', () => {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });
</script>
</html>