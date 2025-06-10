<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - SIPASTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/x-icon">
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-50 px-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl flex flex-col md:flex-row overflow-hidden">
        <div class="hidden md:block md:w-1/2 h-64 md:h-auto overflow-hidden">
            <img src="{{ asset('assets/image/gedung.jpeg') }}" alt="Gedung Kampus" class="w-full h-full object-cover rounded-b-2xl md:rounded-none md:rounded-l-2xl" />
        </div>
        <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-10 py-6 overflow-y-auto max-h-screen">
            <div class="w-full max-w-md space-y-6">
                <div class="flex flex-col items-center">
                    <a href="/">
                        <img src="{{ asset('assets/image/sipasti.svg') }}" alt="Logo SIPASTI" class="h-12 mb-2">
                    </a>
                    <div class="w-full border-t-2 border-[#1652B7] mt-1 mb-4"></div>
                    <p class="text-sm text-center text-gray-600">Silahkan masukkan detail Anda untuk mendaftar</p>
                </div>
                <form method="POST" action="/api/register" class="space-y-6">
                    @csrf
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fa-solid fa-layer-group"></i>
                        </span>
                        <select name="level" id="level"
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-md 
                            hover:shadow-lg transition-shadow duration-300 text-gray-700">
                            <option selected disabled>Pilih Role</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="tendik">Tenaga Kependidikan</option>
                            <option value="sarpras">Sarana Prasarana</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fa-solid fa-id-card"></i>
                        </span>
                        <input type="text" name="nama" id="nama" placeholder="Nama Lengkap"
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-md 
                            hover:shadow-lg transition-shadow duration-300" />
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" id="username" placeholder="Username"
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-md 
                            hover:shadow-lg transition-shadow duration-300" />
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input name="password" id="password" placeholder="Password"
                            class="pl-10 pr-10 py-2 w-full border border-gray-300 rounded-md 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:shadow-md 
                            hover:shadow-lg transition-shadow duration-300" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </div>
                    </div>
                    <button type="submit" id="registerButton"
                        class="w-full bg-[#1652B7] hover:bg-[#143f8a] text-white font-semibold py-2 
                        rounded-md transition-all duration-300 shadow hover:shadow-lg">
                        REGISTER
                    </button>
                </form>
                <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                    <span>Sudah punya akun?</span>
                    <a href="{{ url('/login') }}" class="text-blue-600 hover:underline">Login disini</a>
                </div>
            </div>
        </div>
    </div>
    <div id="modalNotification" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 hidden z-50">
        <div class="relative bg-white rounded-lg p-6 w-80 max-w-full shadow-lg flex flex-col items-center">
            <button id="modalCloseBtn" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-lg focus:outline-none">
                <i class="fas fa-xmark"></i>
            </button>
            <div id="modalContent" class="text-center mt-2"></div>
        </div>
    </div>
    <script>
        const modal = document.getElementById('modalNotification');
        const modalContent = document.getElementById('modalContent');
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const registerButton = document.getElementById('registerButton');

        // Toggle password visibility
        toggle.addEventListener('click', () => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Close modal when close button is clicked
        modalCloseBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        registerButton.addEventListener('click', (e) => {
            e.preventDefault();
            $.ajax({
                url: '/api/do-register',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    level: document.getElementById('level').value,
                    nama: document.getElementById('nama').value,
                    username: document.getElementById('username').value,
                    password: document.getElementById('password').value,
                },
                success: function(response) {
                    if (!response.success) {
                        showModal(response.message, 'error');
                    } else {
                        showModal('Berhasil mendaftar, silahkan login', 'success');
                        window.location.href = '/login';
                    }
                },
            });
        });

        // Function to display modal with dynamic message and type
        function showModal(message, type) {
            let colorClass = 'text-gray-700';
            let iconClass = 'fa-info-circle';
            let iconColor = 'text-gray-500';

            if (type === 'success') {
                colorClass = 'text-green-600';
                iconClass = 'fa-circle-check';
                iconColor = 'text-green-500';
            } else if (type === 'error') {
                colorClass = 'text-red-600';
                iconClass = 'fa-circle-xmark';
                iconColor = 'text-red-500';
            }

            modalContent.innerHTML = `
                <div class="flex flex-col items-center space-y-2">
                <i class="fas ${iconClass} text-4xl ${iconColor}"></i>
                <p class="${colorClass} font-semibold text-center">${message}</p>
                </div>`;
            modal.classList.remove('hidden');
        }

        // Display modal based on session status or validation errors on page load
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('status'))
                showModal(@json(session('status')), 'success');
            @elseif($errors->any())
                @if($errors->has('error'))
                    showModal(@json($errors->first('error')), 'error');
                @else
                    showModal('Harap lengkapi semua isian!', 'error');
                @endif
            @endif
        });
    </script>
</body>
</html>