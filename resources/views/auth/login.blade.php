<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    {{-- Memuat Tailwind CSS melalui CDN. --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- MEMUAT FONT AWESOME UNTUK IKON --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 25%, #991b1b 50%, #7f1d1d 75%, #450a0a 100%);
            min-height: 100vh;
        }

        /* Mengatur ukuran ikon. Warna diatur langsung pada elemen <i> di HTML menggunakan kelas Tailwind. */
        .logo-icon {
            font-size: 3rem; /* Ukuran ikon yang pas */
            animation: pulse 2s infinite;
        }

        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .input-field:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.6);
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
        }

        .checkbox-custom {
            accent-color: #dc2626;
        }

        .link-hover:hover {
            color: #dc2626;
            text-decoration: underline;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .error-alert {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md p-8 form-container rounded-2xl">
        <div class="flex justify-center mb-6">
            {{-- Menggunakan ikon Font Awesome dengan warna merah (text-red-600) --}}
            <i class="fa-solid fa-heart-circle-bolt logo-icon text-red-600"></i>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang Kembali</h1>
            <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        {{-- Menampilkan pesan error validasi global --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-r-lg error-alert" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Email Address --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-red-500"></i>Email
                </label>
                <input id="email"
                       class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       placeholder="Masukkan email Anda" />
                @error('email')
                    <p class="text-sm text-red-600 mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-red-500"></i>Kata Sandi
                </label>
                <input id="password"
                       class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                       type="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="Masukkan kata sandi Anda" />
                @error('password')
                    <p class="text-sm text-red-600 mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center cursor-pointer">
                    <input id="remember_me"
                           type="checkbox"
                           class="checkbox-custom rounded border-gray-300 shadow-sm focus:ring-red-500"
                           name="remember">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 link-hover transition-colors duration-200"
                       href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="btn-primary w-full py-3 rounded-lg font-semibold text-white uppercase tracking-wide transition-all duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
            </button>

            {{-- Link ke halaman register --}}
            <div class="text-center pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a class="font-semibold text-red-600 link-hover transition-colors duration-200"
                       href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
