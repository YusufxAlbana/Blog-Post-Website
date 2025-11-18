# Security Best Practices

## Implementasi Keamanan yang Sudah Ada

### 1. Rate Limiting
- Throttle middleware untuk mencegah spam messages
- Limit: 10 messages per menit per IP

### 2. Input Validation
- Semua input divalidasi menggunakan Laravel validation
- Max length untuk message: 2000 karakter
- Email validation untuk field email

### 3. XSS Protection
- Blade template engine otomatis escape output dengan `{{ }}`
- Gunakan `{!! !!}` hanya untuk trusted content

### 4. CSRF Protection
- Laravel otomatis protect semua POST/PUT/DELETE requests
- Token CSRF di-generate untuk setiap form

### 5. SQL Injection Protection
- Eloquent ORM menggunakan prepared statements
- Tidak ada raw queries tanpa parameter binding

### 6. Authorization
- PostPolicy untuk memastikan hanya owner yang bisa edit/delete post
- Middleware auth untuk protected routes

## Rekomendasi Tambahan

### 1. Content Sanitization

Install HTMLPurifier untuk sanitize HTML content:

```bash
composer require mews/purifier
```

Update PostController untuk sanitize body:

```php
use Mews\Purifier\Facades\Purifier;

$validated['body'] = Purifier::clean($validated['body']);
```

### 2. reCAPTCHA untuk Anti-Spam

Install package:

```bash
composer require anhskohbo/no-captcha
```

Publish config:

```bash
php artisan vendor:publish --provider="Anhskohbo\NoCaptcha\NoCaptchaServiceProvider"
```

Update .env:

```env
NOCAPTCHA_SITEKEY=your_site_key
NOCAPTCHA_SECRET=your_secret_key
```

Tambahkan di ChatBox form:

```blade
{!! NoCaptcha::renderJs() !!}
{!! NoCaptcha::display() !!}
```

Validate di Livewire:

```php
protected $rules = [
    'g-recaptcha-response' => 'required|captcha',
    // ... rules lainnya
];
```

### 3. Security Headers

Install package:

```bash
composer require bepsvpt/secure-headers
```

Publish config:

```bash
php artisan vendor:publish --provider="Bepsvpt\SecureHeaders\SecureHeadersServiceProvider"
```

Edit `config/secure-headers.php`:

```php
'csp' => [
    'default-src' => [
        'self',
    ],
    'script-src' => [
        'self',
        'unsafe-inline', // untuk Livewire
        'unsafe-eval',   // untuk Livewire
    ],
    'style-src' => [
        'self',
        'unsafe-inline',
    ],
],
```

### 4. File Upload Security (jika menambahkan fitur upload)

```php
// Validate file type
$request->validate([
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
]);

// Generate unique filename
$filename = Str::random(32) . '.' . $file->extension();

// Store di private storage
$path = $file->storeAs('uploads', $filename, 'private');
```

### 5. Database Backup

Install Spatie Backup:

```bash
composer require spatie/laravel-backup
```

Publish config:

```bash
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
```

Setup cron untuk auto backup:

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('backup:clean')->daily()->at('01:00');
    $schedule->command('backup:run')->daily()->at('02:00');
}
```

### 6. Environment Variables

**JANGAN PERNAH** commit `.env` ke git!

Pastikan `.env` ada di `.gitignore`:

```
.env
.env.backup
.env.production
```

### 7. HTTPS Only (Production)

Update `app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    if ($this->app->environment('production')) {
        \URL::forceScheme('https');
    }
}
```

### 8. Hide Laravel Version

Edit `public/index.php` - remove atau obfuscate Laravel headers.

Update `.htaccess`:

```apache
# Hide server signature
ServerSignature Off

# Disable directory browsing
Options -Indexes
```

### 9. Logging & Monitoring

Monitor failed login attempts:

```php
// app/Listeners/LogFailedLogin.php
public function handle(Failed $event)
{
    Log::warning('Failed login attempt', [
        'email' => $event->credentials['email'],
        'ip' => request()->ip(),
    ]);
}
```

### 10. Two-Factor Authentication (Optional)

Install Laravel Fortify:

```bash
composer require laravel/fortify
php artisan fortify:install
php artisan migrate
```

Enable 2FA di `config/fortify.php`:

```php
'features' => [
    Features::twoFactorAuthentication([
        'confirmPassword' => true,
    ]),
],
```

## Security Checklist untuk Production

- [ ] Update semua dependencies: `composer update`
- [ ] Audit dependencies: `composer audit`
- [ ] Enable HTTPS dengan valid SSL certificate
- [ ] Set `APP_DEBUG=false` di production
- [ ] Set `APP_ENV=production`
- [ ] Generate strong `APP_KEY`
- [ ] Restrict database user permissions
- [ ] Setup firewall (UFW/iptables)
- [ ] Disable unused services
- [ ] Setup fail2ban untuk protect SSH
- [ ] Regular backup database & files
- [ ] Monitor logs: `storage/logs/laravel.log`
- [ ] Setup error tracking (Sentry, Bugsnag)
- [ ] Rate limit API endpoints
- [ ] Implement CORS properly
- [ ] Sanitize user input
- [ ] Validate file uploads
- [ ] Use prepared statements (Eloquent does this)
- [ ] Implement proper session management
- [ ] Set secure cookie flags
- [ ] Regular security updates

## Reporting Security Issues

Jika menemukan security vulnerability, jangan buat public issue. Email ke: security@yourdomain.com

## Resources

- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
