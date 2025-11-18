# Laravel Blog dengan Real-Time Chat

Blog pribadi sederhana dengan fitur chat/komentar real-time menggunakan Laravel, Livewire, dan Laravel Echo.

## Fitur

- ✅ CRUD Post (Create, Read, Update, Delete)
- ✅ Real-time chat/komentar pada setiap post
- ✅ Autentikasi user (Laravel Breeze)
- ✅ Broadcasting real-time dengan Laravel Echo + Pusher
- ✅ Email notification untuk pesan baru
- ✅ Moderasi pesan (opsional)
- ✅ Responsive design dengan Tailwind CSS

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade + Tailwind CSS + Alpine.js
- **Real-time**: Livewire + Laravel Echo + Pusher
- **Database**: MySQL
- **Authentication**: Laravel Breeze

## Instalasi

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd laravel_blog
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan konfigurasi:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel_blog
DB_USERNAME=root
DB_PASSWORD=

# Broadcasting (untuk real-time chat)
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http

# Mail (untuk notifikasi)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ADMIN_ADDRESS=admin@example.com

# Blog Settings
BLOG_MODERATE_MESSAGES=false
```

### 3. Database Migration & Seeding

```bash
php artisan migrate
php artisan db:seed
```

Ini akan membuat:
- User default: `admin@example.com` / `password`
- 3 post contoh

### 4. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 5. Setup Broadcasting (Real-Time)

#### Opsi A: Menggunakan Laravel WebSockets (Self-Hosted)

```bash
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider"
php artisan migrate
```

Jalankan WebSocket server:
```bash
php artisan websockets:serve
```

#### Opsi B: Menggunakan Pusher (Managed Service)

1. Daftar di [pusher.com](https://pusher.com)
2. Buat app baru
3. Update `.env` dengan credentials Pusher Anda

### 6. Queue Worker (untuk Email Notifications)

```bash
php artisan queue:work
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

## Penggunaan

### Membuat Post Baru

1. Login dengan akun yang sudah dibuat
2. Klik "Create New Post" di halaman utama
3. Isi judul dan konten
4. Centang "Publish immediately" jika ingin langsung publish
5. Klik "Create Post"

### Chat/Komentar Real-Time

1. Buka halaman post
2. Scroll ke bawah ke bagian "Chat & Comments"
3. Isi nama (opsional), email (opsional), dan pesan
4. Klik "Send Message"
5. Pesan akan muncul secara real-time untuk semua pengunjung yang membuka post tersebut

### Moderasi Pesan

Jika ingin mengaktifkan moderasi (pesan harus diapprove dulu sebelum tampil):

1. Set `BLOG_MODERATE_MESSAGES=true` di `.env`
2. Buat halaman admin untuk approve messages (belum diimplementasi dalam versi ini)

## Struktur Project

```
app/
├── Events/
│   └── MessagePosted.php          # Event untuk broadcast pesan baru
├── Http/
│   └── Controllers/
│       └── PostController.php     # Controller untuk CRUD post
├── Livewire/
│   └── ChatBox.php                # Livewire component untuk chat
├── Models/
│   ├── Post.php                   # Model Post
│   └── Message.php                # Model Message
├── Notifications/
│   └── NewMessageNotification.php # Email notification
└── Policies/
    └── PostPolicy.php             # Authorization policy

resources/
├── views/
│   ├── livewire/
│   │   └── chat-box.blade.php    # View Livewire chat
│   └── posts/
│       ├── index.blade.php       # List posts
│       ├── show.blade.php        # Detail post + chat
│       ├── create.blade.php      # Form create post
│       └── edit.blade.php        # Form edit post
└── js/
    └── bootstrap.js              # Laravel Echo setup

config/
└── blog.php                      # Konfigurasi blog (moderasi, dll)
```

## Commands Penting

```bash
# Development
php artisan serve                 # Jalankan server
npm run dev                       # Build assets (watch mode)
php artisan queue:work            # Jalankan queue worker
php artisan websockets:serve      # Jalankan WebSocket server (jika pakai laravel-websockets)

# Production
npm run build                     # Build assets untuk production
php artisan config:cache          # Cache konfigurasi
php artisan route:cache           # Cache routes
php artisan view:cache            # Cache views

# Database
php artisan migrate               # Jalankan migrations
php artisan migrate:fresh --seed  # Reset database + seed
php artisan db:seed               # Seed data saja

# Maintenance
php artisan cache:clear           # Clear cache
php artisan config:clear          # Clear config cache
php artisan route:clear           # Clear route cache
php artisan view:clear            # Clear view cache
```

## Deployment

### Setup Supervisor (untuk Queue & WebSockets)

Buat file `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/storage/logs/worker.log

[program:laravel-websockets]
process_name=%(program_name)s
command=php /path/to/artisan websockets:serve
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/path/to/storage/logs/websockets.log
```

Reload supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Troubleshooting

### Real-time chat tidak berfungsi

1. Pastikan WebSocket server berjalan: `php artisan websockets:serve`
2. Cek konfigurasi `.env` untuk `BROADCAST_CONNECTION` dan `PUSHER_*`
3. Pastikan `npm run dev` atau `npm run build` sudah dijalankan
4. Buka browser console untuk melihat error

### Email tidak terkirim

1. Cek konfigurasi MAIL di `.env`
2. Pastikan queue worker berjalan: `php artisan queue:work`
3. Cek log: `storage/logs/laravel.log`

### Error 500 setelah deployment

1. Jalankan: `php artisan config:cache`
2. Set permission: `chmod -R 775 storage bootstrap/cache`
3. Set owner: `chown -R www-data:www-data /path/to/project`

## Lisensi

Open source - silakan digunakan dan dimodifikasi sesuai kebutuhan.
