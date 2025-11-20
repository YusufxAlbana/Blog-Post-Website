<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - BLOGMOUS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: #0a0a0a;
            color: #E0E0E0;
        }
        .gradient-text {
            background: linear-gradient(135deg, #8A2BE2, #9D4EDD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .input-field {
            background: #1a1a1a !important;
            border: 1px solid #8A2BE2;
            color: #E0E0E0 !important;
            transition: all 0.3s ease;
            -webkit-text-fill-color: #E0E0E0 !important;
        }
        .input-field:focus {
            outline: none;
            border-color: #8A2BE2;
            background: #1a1a1a !important;
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.2);
        }
        .input-field::placeholder {
            color: #4B5563;
            opacity: 0.6;
        }
        .input-field:-webkit-autofill,
        .input-field:-webkit-autofill:hover,
        .input-field:-webkit-autofill:focus,
        .input-field:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1a1a1a inset !important;
            -webkit-text-fill-color: #E0E0E0 !important;
            box-shadow: 0 0 0 30px #1a1a1a inset !important;
            border: 1px solid #8A2BE2 !important;
        }
        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: #1a1a1a !important;
            border: 2px solid #8A2BE2 !important;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        input[type="checkbox"]:checked {
            background: #8A2BE2 !important;
            border-color: #8A2BE2 !important;
        }
        input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 14px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        input[type="checkbox"]:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.2) !important;
            border-color: #8A2BE2 !important;
        }
        .auth-card {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(138, 43, 226, 0.2);
            box-shadow: 0 8px 32px rgba(138, 43, 226, 0.2);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(138, 43, 226, 0.3) 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="w-full max-w-md relative z-10 fade-in">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3 mb-4">
                <div class="h-12 w-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6));">
                </div>
                <span class="text-3xl font-bold gradient-text">BLOGMOUS</span>
            </a>
            <h1 class="text-2xl font-bold mb-2">Lupa Password?</h1>
            <p style="color: #9CA3AF;">Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link reset password</p>
        </div>

        <!-- Forgot Password Card -->
        <div class="auth-card rounded-2xl p-8">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-lg" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #4ade80;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold mb-2" style="color: #E0E0E0;">
                        Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="input-field w-full px-4 py-3 rounded-lg"
                        placeholder="nama@email.com"
                    />
                    @error('email')
                        <p class="mt-2 text-sm" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 rounded-lg font-semibold transition-all"
                    style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white; box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'"
                    onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'"
                >
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t" style="border-color: rgba(138, 43, 226, 0.2);"></div>
                </div>
            </div>

            <!-- Back to Login -->
            <a 
                href="{{ route('login') }}" 
                class="block w-full py-3 rounded-lg font-semibold text-center transition-all"
                style="border: 2px solid rgba(138, 43, 226, 0.5); color: #E0E0E0;"
                onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'"
                onmouseout="this.style.background=''"
            >
                Kembali ke Login
            </a>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('welcome') }}" class="text-sm transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#E0E0E0'" onmouseout="this.style.color='#9CA3AF'">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
