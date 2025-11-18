# Avatar Upload Guide

## Cara Upload Profile Picture

### Akses Profile
1. Login ke akun Anda
2. Klik nama Anda di navigation bar → "Profile"
3. Klik tombol "Edit Profile" di pojok kanan atas

### Method 1: Click to Upload
1. Di mode edit, klik area "Click to upload"
2. Pilih file gambar dari komputer Anda
3. Preview akan muncul otomatis di view mode dan edit mode
4. Klik "Save Changes" untuk menyimpan
5. Otomatis kembali ke view mode

### Method 2: Drag & Drop
1. Di mode edit, drag file gambar dari komputer Anda
2. Drop ke area upload (kotak dengan icon upload)
3. Preview akan muncul otomatis
4. Klik "Save Changes" untuk menyimpan
5. Otomatis kembali ke view mode

### Method 3: Remove Avatar
1. Di mode edit, jika sudah ada avatar, akan muncul tombol X merah di pojok kanan atas avatar
2. Klik tombol X untuk menghapus avatar
3. Avatar akan kembali ke default (initial nama)
4. Klik "Save Changes" untuk menyimpan

## Spesifikasi File
- **Format**: JPG, PNG, GIF
- **Ukuran Maksimal**: 2MB
- **Validasi**: Otomatis di client-side dan server-side

## Fitur
- ✅ **Unified Profile Page**: View dan edit dalam satu halaman
- ✅ **Toggle Edit Mode**: Klik "Edit Profile" untuk masuk mode edit
- ✅ **Live preview**: Preview di view mode dan edit mode sekaligus
- ✅ **Drag & drop support**: Drag file langsung ke area upload
- ✅ **Validasi**: Ukuran dan format file otomatis dicek
- ✅ **Remove avatar**: Hapus avatar dengan satu klik
- ✅ **Default avatar**: Initial nama jika tidak ada upload (UI Avatars)
- ✅ **Auto delete**: Avatar lama otomatis terhapus saat upload baru
- ✅ **Change password**: Ganti password di halaman yang sama
- ✅ **Avatar display**: Ditampilkan di navigation, blog posts, profile
- ✅ **Public profile**: User lain bisa lihat profile (tanpa tombol edit)

## Troubleshooting

### File terlalu besar
- Compress gambar menggunakan tools online
- Resize gambar ke ukuran lebih kecil (recommended: 400x400px)

### Format tidak didukung
- Convert gambar ke JPG atau PNG
- Gunakan tools seperti Paint, Photoshop, atau online converter

### Avatar tidak muncul
- Pastikan sudah klik "Save" setelah upload
- Clear browser cache
- Cek apakah storage link sudah dibuat: `php artisan storage:link`
