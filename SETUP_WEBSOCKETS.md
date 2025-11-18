# Setup WebSockets untuk Real-Time Chat

Ada 2 opsi untuk mengimplementasikan real-time chat:

## Opsi 1: Laravel WebSockets (Self-Hosted) - RECOMMENDED untuk Development

### Install Package

```bash
composer require beyondcode/laravel-websockets
```

### Publish Config & Migrate

```bash
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate

php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
```

### Update .env

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Jalankan WebSocket Server

```bash
php artisan websockets:serve
```

Server akan berjalan di `http://127.0.0.1:6001`

### Dashboard WebSockets

Akses dashboard di: `http://localhost:8000/laravel-websockets`

Di sini Anda bisa monitor:
- Connections aktif
- Messages yang dikirim
- Statistics real-time

### Testing

1. Buka 2 browser window
2. Buka post yang sama di kedua window
3. Kirim message dari window pertama
4. Message akan muncul real-time di window kedua

---

## Opsi 2: Pusher (Managed Service) - RECOMMENDED untuk Production

### Daftar Pusher

1. Buka [pusher.com](https://pusher.com)
2. Sign up / Login
3. Create new app
4. Pilih region terdekat
5. Copy credentials

### Update .env

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=ap1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST=
VITE_PUSHER_PORT=443
VITE_PUSHER_SCHEME=https
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Install Pusher PHP SDK

```bash
composer require pusher/pusher-php-server
```

### Rebuild Assets

```bash
npm run build
```

### Testing

Sama seperti opsi 1, tapi tidak perlu menjalankan `websockets:serve`

---

## Troubleshooting

### Connection Failed

**Problem**: Browser console menunjukkan error "WebSocket connection failed"

**Solution**:
1. Pastikan WebSocket server berjalan: `php artisan websockets:serve`
2. Cek port 6001 tidak digunakan aplikasi lain
3. Cek firewall tidak memblokir port 6001

### Messages Tidak Muncul Real-Time

**Problem**: Message tersimpan tapi tidak broadcast

**Solution**:
1. Cek `.env`: `BROADCAST_CONNECTION=pusher`
2. Cek `config/broadcasting.php` sudah benar
3. Clear config cache: `php artisan config:clear`
4. Rebuild assets: `npm run build`
5. Restart WebSocket server

### CORS Error

**Problem**: Browser console menunjukkan CORS error

**Solution**:
Edit `config/websockets.php`:

```php
'apps' => [
    [
        'id' => env('PUSHER_APP_ID'),
        'name' => env('APP_NAME'),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'enable_client_messages' => false,
        'enable_statistics' => true,
        'allowed_origins' => ['*'], // atau specify domain Anda
    ],
],
```

### Production Deployment

Untuk production dengan Laravel WebSockets:

1. Setup Supervisor untuk auto-restart WebSocket server
2. Setup SSL/TLS certificate
3. Configure nginx reverse proxy untuk WebSocket
4. Update `PUSHER_SCHEME=https` dan `PUSHER_PORT=443`

Contoh Nginx config untuk WebSocket:

```nginx
location /app {
    proxy_pass http://127.0.0.1:6001;
    proxy_http_version 1.1;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection "Upgrade";
    proxy_set_header Host $host;
}
```

---

## Performance Tips

1. **Limit Message History**: Hanya load 50 pesan terakhir (sudah diimplementasi)
2. **Throttle Messages**: Gunakan rate limiting untuk prevent spam
3. **Queue Notifications**: Email notifications sudah menggunakan queue
4. **Cache**: Cache post data untuk reduce database queries
5. **CDN**: Serve static assets via CDN untuk production

---

## Monitoring

### Laravel WebSockets Dashboard

Akses: `http://localhost:8000/laravel-websockets`

Monitor:
- Active connections
- Messages per second
- Channel subscriptions
- Statistics

### Pusher Dashboard

Akses: [dashboard.pusher.com](https://dashboard.pusher.com)

Monitor:
- Connection count
- Message count
- API requests
- Errors & logs
