<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SIPASTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/x-icon">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-blue-50 px-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl flex flex-col md:flex-row overflow-hidden">
        <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-10 py-6">
            <div class="w-full max-w-md">
                <div class="w-full max-w-md space-y-6">
                    <div class="flex flex-col items-center mt-[-20px] mb-[40px]">
                        <a href="/">
                            <img src="{{ asset('assets/image/sipasti.svg') }}" alt="Logo SIPASTI" class="h-12 mb-2">
                        </a>
                        <div class="w-full border-t-2 border-[#1652B7] mt-1 mb-4"></div>
                        <p class="text-sm text-center text-gray-600">Silahkan masukkan detail Anda untuk masuk</p>
                    </div>
                    <form method="POST" action="/login" class="space-y-6">
                        @csrf
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
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer"
                                id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#1652B7] hover:bg-[#143f8a] text-white font-semibold py-2
                            rounded-md transition-all duration-300 shadow hover:shadow-lg">
                            Login
                        </button>
                    </form>
                    <div class="flex items-center justify-center space-x-2 text-sm text-gray-500 mt-4">
                        <span>Belum punya akun?</span>
                        <a href="{{ url('/register') }}" class="text-blue-600 hover:underline">Daftar disini</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden md:block md:w-1/2 h-64 md:h-auto overflow-hidden">
            <img src="{{ asset('assets/image/gedung.jpeg') }}" alt="Dashboard Preview"
                class="w-full h-full object-cover rounded-b-2xl md:rounded-none md:rounded-r-2xl" />
        </div>
    </div>
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

        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: message,
                timer: 3000,
                showConfirmButton: true
            });
        }

        function showDelete(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if (session('status'))
                showSuccess(@json(session('status')));
            @elseif ($errors->any())
                @if ($errors->has('error'))
                    showError(@json($errors->first('error')));
                @else
                    showError('Harap lengkapi semua isian!');
                @endif
            @endif
        });
    </script>
</body>

</html>
