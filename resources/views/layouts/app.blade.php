<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Dark Theme Styles -->
        <style>
            :root {
                --bg-primary: #0D0D0D;
                --bg-secondary: #1A1A1A;
                --text-primary: #E0E0E0;
                --accent-primary: #8A2BE2;
                --accent-secondary: #5A189A;
                --border-color: rgba(138, 43, 226, 0.2);
            }
            
            body { background-color: var(--bg-primary); color: var(--text-primary); }
            * { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            
            ::-webkit-scrollbar { width: 10px; }
            ::-webkit-scrollbar-track { background: var(--bg-primary); }
            ::-webkit-scrollbar-thumb { background: var(--accent-secondary); border-radius: 5px; }
            ::-webkit-scrollbar-thumb:hover { background: var(--accent-primary); }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .fade-in { animation: fadeIn 0.6s ease-out; }
            
            .post-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(138, 43, 226, 0.15);
                border-color: #8A2BE2 !important;
            }
            
            .gradient-text {
                background: linear-gradient(135deg, #8A2BE2, #9D4EDD);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            /* Navbar scroll animation */
            .navbar-header {
                position: sticky;
                top: 0;
                z-index: 40;
                transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            }
            .navbar-hidden {
                transform: translateY(-100%);
                opacity: 0;
            }
            .navbar-visible {
                transform: translateY(0);
                opacity: 1;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" style="background-color: var(--bg-primary)">
            @include('layouts.navigation')

            <!-- Main Content with Sidebar Offset -->
            <div class="lg:pl-64">
                <!-- Page Heading -->
                @isset($header)
                    <header class="navbar-header navbar-visible" style="background: rgba(26, 26, 26, 0.95); border-bottom: 1px solid rgba(138, 43, 226, 0.2); backdrop-filter: blur(10px);">
                        <div class="py-6 px-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <script>
            // Navbar hide/show on scroll
            let lastScrollTop = 0;
            let scrollThreshold = 10; // Minimum scroll distance to trigger hide/show (reduced from 100 to 10)
            
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar-header');
                if (!navbar) return;
                
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // If at top of page, always show navbar
                if (scrollTop <= 10) {
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                    lastScrollTop = scrollTop;
                    return;
                }
                
                // Check scroll direction with minimal threshold
                if (scrollTop > lastScrollTop + 5 && scrollTop > scrollThreshold) {
                    // Scrolling down - hide navbar
                    navbar.classList.add('navbar-hidden');
                    navbar.classList.remove('navbar-visible');
                } else if (scrollTop < lastScrollTop - 5) {
                    // Scrolling up - show navbar
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                }
                
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            }, false);
        </script>
    </body>
</html>
