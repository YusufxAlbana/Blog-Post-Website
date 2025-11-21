<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                Information
            </h2>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6 max-w-5xl mx-auto space-y-6">
            
            <!-- Hero Section -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-8 text-center" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);">
                <div class="flex justify-center mb-4">
                    <div class="h-20 w-20 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.3), rgba(90, 24, 154, 0.3)); border: 2px solid rgba(138, 43, 226, 0.5);">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-16 w-16 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6));">
                    </div>
                </div>
                <h1 class="text-4xl font-bold mb-2" style="background: linear-gradient(135deg, #8A2BE2, #DA70D6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">BLOGMOUS</h1>
                <p class="text-xl mb-2" style="color: #E0E0E0;">Anonymous Blogging Platform</p>
                <p class="text-sm" style="color: rgba(224, 224, 224, 0.7);">Version 1.0.0 • Built with Laravel 11 & Livewire</p>
            </div>

            <!-- About Section -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4" style="color: #E0E0E0;">Tentang BLOGMOUS</h3>
                    <div class="space-y-4" style="color: #B0B0B0; line-height: 1.8;">
                        <p>
                            BLOGMOUS adalah platform blogging yang memberikan kebebasan kepada pengguna untuk berbagi pemikiran, cerita, dan ide secara anonim atau dengan identitas asli mereka. Platform ini dibangun dengan fokus pada privasi, keamanan, dan kemudahan penggunaan.
                        </p>
                        <p>
                            Dengan fitur Anonymous Mode, setiap pengguna dapat beralih antara mode normal dan mode anonim, memungkinkan mereka untuk mengekspresikan diri tanpa khawatir tentang identitas mereka. Ini menciptakan ruang yang aman untuk berbagi pengalaman pribadi, opini kontroversial, atau cerita yang sensitif.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Why BLOGMOUS -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4" style="color: #E0E0E0;">Mengapa BLOGMOUS?</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-lg" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                    <svg class="w-6 h-6" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold" style="color: #E0E0E0;">Privasi Terjamin</h4>
                            </div>
                            <p class="text-sm" style="color: #9CA3AF;">Mode anonim memungkinkan Anda berbagi tanpa mengungkapkan identitas asli Anda.</p>
                        </div>

                        <div class="p-4 rounded-lg" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                    <svg class="w-6 h-6" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold" style="color: #E0E0E0;">Keamanan Data</h4>
                            </div>
                            <p class="text-sm" style="color: #9CA3AF;">Data Anda dilindungi dengan enkripsi dan sistem keamanan modern.</p>
                        </div>

                        <div class="p-4 rounded-lg" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                    <svg class="w-6 h-6" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold" style="color: #E0E0E0;">Komunitas Aktif</h4>
                            </div>
                            <p class="text-sm" style="color: #9CA3AF;">Bergabung dengan komunitas yang saling mendukung dan menghargai privasi.</p>
                        </div>

                        <div class="p-4 rounded-lg" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                    <svg class="w-6 h-6" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold" style="color: #E0E0E0;">Interaksi Real-time</h4>
                            </div>
                            <p class="text-sm" style="color: #9CA3AF;">Chat, komentar, dan notifikasi real-time untuk pengalaman yang lebih interaktif.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4" style="color: #E0E0E0;">Fitur Utama</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 rounded-lg transition-all" style="background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background='rgba(40, 40, 40, 0.5)'">
                            <div class="w-2 h-2 rounded-full mt-2" style="background: #8A2BE2;"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Anonymous Mode</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Beralih antara mode normal dan anonim dengan satu klik. Identitas Anda tetap terlindungi saat dalam mode anonim.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg transition-all" style="background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background='rgba(40, 40, 40, 0.5)'">
                            <div class="w-2 h-2 rounded-full mt-2" style="background: #8A2BE2;"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Rich Text Editor</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Buat post dengan format teks yang kaya, tambahkan hingga 10 gambar, dan ekspresikan ide Anda dengan lebih baik.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg transition-all" style="background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background='rgba(40, 40, 40, 0.5)'">
                            <div class="w-2 h-2 rounded-full mt-2" style="background: #8A2BE2;"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Social Interaction</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Like, comment, follow user lain, dan bangun koneksi dengan komunitas yang memiliki minat yang sama.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg transition-all" style="background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background='rgba(40, 40, 40, 0.5)'">
                            <div class="w-2 h-2 rounded-full mt-2" style="background: #8A2BE2;"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Direct Messaging</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Kirim pesan pribadi ke user lain atau buat group chat untuk diskusi yang lebih intim.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg transition-all" style="background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background='rgba(40, 40, 40, 0.5)'">
                            <div class="w-2 h-2 rounded-full mt-2" style="background: #8A2BE2;"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Personalized Feed</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Tab "For You" menampilkan konten yang relevan, sementara tab "Following" menampilkan post dari user yang Anda ikuti.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg transition-all" style="background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background='rgba(40, 40, 40, 0.5)'">
                            <div class="w-2 h-2 rounded-full mt-2" style="background: #8A2BE2;"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Notification System</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Dapatkan notifikasi untuk komentar, likes, dan pesan baru agar tidak ketinggalan interaksi penting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4" style="color: #E0E0E0;">Teknologi yang Digunakan</h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-lg text-center" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="text-3xl mb-2">🚀</div>
                            <h4 class="font-bold mb-1" style="color: #E0E0E0;">Laravel 11</h4>
                            <p class="text-sm" style="color: #9CA3AF;">PHP Framework Modern</p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="text-3xl mb-2">⚡</div>
                            <h4 class="font-bold mb-1" style="color: #E0E0E0;">Livewire 3</h4>
                            <p class="text-sm" style="color: #9CA3AF;">Real-time Interactivity</p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="text-3xl mb-2">🎨</div>
                            <h4 class="font-bold mb-1" style="color: #E0E0E0;">Tailwind CSS</h4>
                            <p class="text-sm" style="color: #9CA3AF;">Utility-First CSS</p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="text-3xl mb-2">🗄️</div>
                            <h4 class="font-bold mb-1" style="color: #E0E0E0;">MySQL</h4>
                            <p class="text-sm" style="color: #9CA3AF;">Relational Database</p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="text-3xl mb-2">🔐</div>
                            <h4 class="font-bold mb-1" style="color: #E0E0E0;">Laravel Breeze</h4>
                            <p class="text-sm" style="color: #9CA3AF;">Authentication System</p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="text-3xl mb-2">📦</div>
                            <h4 class="font-bold mb-1" style="color: #E0E0E0;">Composer</h4>
                            <p class="text-sm" style="color: #9CA3AF;">Dependency Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Version Info -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4" style="color: #E0E0E0;">Informasi Versi</h3>
                    <div class="space-y-2" style="color: #B0B0B0;">
                        <div class="flex justify-between py-2" style="border-bottom: 1px solid rgba(138, 43, 226, 0.1);">
                            <span>Version</span>
                            <span class="font-semibold" style="color: #8A2BE2;">1.0.0</span>
                        </div>
                        <div class="flex justify-between py-2" style="border-bottom: 1px solid rgba(138, 43, 226, 0.1);">
                            <span>Release Date</span>
                            <span class="font-semibold" style="color: #E0E0E0;">November 2025</span>
                        </div>
                        <div class="flex justify-between py-2" style="border-bottom: 1px solid rgba(138, 43, 226, 0.1);">
                            <span>Laravel Version</span>
                            <span class="font-semibold" style="color: #E0E0E0;">11.x</span>
                        </div>
                        <div class="flex justify-between py-2" style="border-bottom: 1px solid rgba(138, 43, 226, 0.1);">
                            <span>PHP Version</span>
                            <span class="font-semibold" style="color: #E0E0E0;">8.2+</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span>License</span>
                            <span class="font-semibold" style="color: #E0E0E0;">MIT License</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact/Support -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6 text-center">
                    <h3 class="text-2xl font-bold mb-4" style="color: #E0E0E0;">Butuh Bantuan?</h3>
                    <p class="mb-6" style="color: #B0B0B0;">Jika Anda memiliki pertanyaan atau menemukan bug, silakan laporkan melalui halaman Feedback.</p>
                    <a href="{{ route('reports.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(138, 43, 226, 0.4)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Report Bug / Feedback
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
