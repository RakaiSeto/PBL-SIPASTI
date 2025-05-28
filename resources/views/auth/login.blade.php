<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - SIPASTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/x-icon">

    @vite('resources/css/app.css', 'resources/js/app.js')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm bg-white rounded-xl shadow-md p-8">
        <div class="flex flex-col items-center mb-4">
            <a href="/">
                <img src="{{ asset('assets/image/sipasti.svg') }}" alt="Logo SIPASTI" class="h-12 mb-2">
            </a>
            <div class="w-full border-t-2 border-[#1652B7] mt-1 mb-4"></div>
            <p class="text-sm text-center text-gray-600">Silahkan masukkan detail Anda untuk masuk</p>
        </div>

        <form method="POST" action="/login" class="space-y-10 mt-4">
            @csrf
            <div>
                <label for="username" class="block text-sm text-gray-700 mb-1 sr-only">Username</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="fas fa-user h-5 w-5 text-gray-400"></span>
                    </div>
                    <input type="text" name="username" id="username" class="block w-full pl-10 border-b-2 border-gray-300 focus:outline-none focus:border-b-blue-500" placeholder="Username">
                </div>
            </div>

            <div>
                <label for="password" class="sr-only">Password</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                     </div>
                    <input type="password" name="password" id="password" class="block w-full pl-10 border-b-2 border-gray-300 focus:outline-none focus:border-b-blue-500" placeholder="Password">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400" id="togglePassword"></div>
                </div>
            </div>

            <button type="submit" class="w-full py-2 rounded-md bg-[#1652B7] text-white font-semibold hover:bg-[#143f8a] transition">
                SIGN IN
            </button>
        </form>

        <p class="mt-4 text-sm text-gray-600">
            Belum punya akun? <a href="{{ url('/register') }}" class="text-blue-600 hover:underline">Daftar disini</a>
        </p>
    </div>
    <div id="modalNotification" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 hidden z-50">
        <div class="relative bg-white rounded-lg p-6 w-80 max-w-full shadow-lg flex flex-col items-center">
            
            <button id="modalCloseBtn" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-lg focus:outline-none">
                <i class="fas fa-xmark"></i>
            </button>
            <div id="modalContent" class="text-center mt-2"></div>
        </div>
    </div>
</body>
<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
    });

        const modal = document.getElementById('modalNotification');
        const modalContent = document.getElementById('modalContent');
        const modalCloseBtn = document.getElementById('modalCloseBtn');

        modalCloseBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

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
                </div>
                `;
            modal.classList.remove('hidden');
        }
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
</html> 