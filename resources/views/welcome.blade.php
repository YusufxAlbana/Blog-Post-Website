<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOGMOUS - Platform Blogging Aman & Anonim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: #0a0a0a;
            color: #E0E0E0;
        }
        .gradient-text {
            background: linear-gradient(135deg, #8A2BE2, #DA70D6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glow-box {
            box-shadow: 0 0 30px rgba(138, 43, 226, 0.3);
            border: 1px solid rgba(138, 43, 226, 0.3);
        }
        .hero-gradient {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), rgba(90, 24, 154, 0.1));
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 backdrop-blur-lg" style="background: rgba(10, 10, 10, 0.8); border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6));">
                    </div>
                    <span class="text-2xl font-bold gradient-text">BLOGMOUS</span>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="px-6 py-2 rounded-lg transition-all" style="color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 rounded-lg font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                        Daftar Gratis
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 fade-in-up">
                Tulis Dengan <span class="gradient-text">Bebas</span>,<br>
                Berbagi Dengan <span class="gradient-text">Aman</span>
            </h1>
            <p class="text-xl md:text-2xl mb-12 fade-in-up" style="color: #9CA3AF; animation-delay: 0.2s;">
                Platform blogging yang melindungi privasi Anda dengan mode anonim dan keamanan tingkat tinggi
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-up" style="animation-delay: 0.4s;">
                <a href="{{ route('register') }}" class="px-8 py-4 rounded-xl text-lg font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white; box-shadow: 0 4px 20px rgba(138, 43, 226, 0.4);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 30px rgba(138, 43, 226, 0.6)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 20px rgba(138, 43, 226, 0.4)'">
                    Mulai Menulis Sekarang
                </a>
                <a href="{{ route('post.index') }}" class="px-8 py-4 rounded-xl text-lg font-semibold transition-all" style="border: 2px solid rgba(138, 43, 226, 0.5); color: #E0E0E0;" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                    Jelajahi Blog
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16">
                Mengapa Memilih <span class="gradient-text">BLOGMOUS</span>?
            </h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl hero-gradient glow-box transition-all" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Mode Anonim</h3>
                    <p style="color: #9CA3AF;">
                        Tulis dan bagikan pemikiran Anda tanpa mengungkapkan identitas. Privasi Anda adalah prioritas kami.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl hero-gradient glow-box transition-all" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Keamanan Terjamin</h3>
                    <p style="color: #9CA3AF;">
                        Data Anda dilindungi dengan enkripsi tingkat tinggi. Sistem moderasi aktif menjaga komunitas tetap aman.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl hero-gradient glow-box transition-all" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Komunitas Aktif</h3>
                    <p style="color: #9CA3AF;">
                        Bergabung dengan ribuan penulis. Follow, like, dan berinteraksi dengan konten yang Anda sukai.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="p-8 rounded-2xl hero-gradient glow-box transition-all" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Direct Messaging</h3>
                    <p style="color: #9CA3AF;">
                        Komunikasi langsung dengan penulis lain secara privat. Bangun koneksi yang bermakna.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="p-8 rounded-2xl hero-gradient glow-box transition-all" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Editor Powerful</h3>
                    <p style="color: #9CA3AF;">
                        Tulis dengan mudah menggunakan editor yang intuitif. Tambahkan gambar, format teks, dan lebih banyak lagi.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="p-8 rounded-2xl hero-gradient glow-box transition-all" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform=''">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">100% Gratis</h3>
                    <p style="color: #9CA3AF;">
                        Semua fitur tersedia gratis tanpa batasan. Tidak ada biaya tersembunyi atau paket premium.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 px-4" style="background: rgba(138, 43, 226, 0.05);">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16">
                Cara Kerja <span class="gradient-text">BLOGMOUS</span>
            </h2>
            
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <span class="text-3xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Daftar Gratis</h3>
                    <p style="color: #9CA3AF;">
                        Buat akun dalam hitungan detik. Hanya butuh email dan password.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <span class="text-3xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Mulai Menulis</h3>
                    <p style="color: #9CA3AF;">
                        Tulis artikel pertama Anda. Pilih mode anonim jika ingin privasi ekstra.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                        <span class="text-3xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Bagikan & Terhubung</h3>
                    <p style="color: #9CA3AF;">
                        Publikasikan konten Anda dan terhubung dengan pembaca di seluruh dunia.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Siap Memulai Perjalanan Menulis Anda?
            </h2>
            <p class="text-xl mb-12" style="color: #9CA3AF;">
                Bergabunglah dengan ribuan penulis yang sudah mempercayai BLOGMOUS sebagai platform blogging mereka.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-12 py-5 rounded-xl text-xl font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white; box-shadow: 0 4px 20px rgba(138, 43, 226, 0.4);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 30px rgba(138, 43, 226, 0.6)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 20px rgba(138, 43, 226, 0.4)'">
                Daftar Sekarang - Gratis!
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-4 border-t" style="border-color: rgba(138, 43, 226, 0.2);">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6));">
                </div>
                <span class="text-2xl font-bold gradient-text">BLOGMOUS</span>
            </div>
            <p style="color: #9CA3AF;">
                Platform blogging aman dan anonim untuk semua orang.
            </p>
            <p class="mt-4" style="color: #6B7280;">
                &copy; 2025 BLOGMOUS. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
