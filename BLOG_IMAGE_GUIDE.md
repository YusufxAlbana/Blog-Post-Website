# Blog Image Upload Guide

## Featured Image untuk Blog Post

### Cara Upload Featured Image

#### Saat Membuat Post Baru
1. Login sebagai Admin
2. Klik "Blog" → "Create New Post"
3. Di bagian atas form, ada area "Featured Image"
4. **Method 1**: Klik area upload untuk pilih gambar dari komputer
5. **Method 2**: Drag & drop gambar langsung ke area upload
6. Preview akan muncul otomatis
7. Isi title dan content
8. Klik "Create Post"

#### Saat Edit Post
1. Login sebagai Admin
2. Buka post yang ingin diedit
3. Klik tombol "Edit"
4. Di bagian "Featured Image":
   - Jika sudah ada gambar, akan tampil dengan tombol X untuk hapus
   - Upload gambar baru akan replace gambar lama
   - Klik tombol X untuk hapus gambar tanpa upload baru
5. Klik "Update Post"

### Spesifikasi Featured Image
- **Format**: JPG, PNG, GIF
- **Ukuran Maksimal**: 5MB
- **Recommended Size**: 1200x630px (landscape)
- **Validasi**: Otomatis di client-side dan server-side

## Tampilan Featured Image

### Di Blog Index (Homepage)
- Featured image ditampilkan di sebelah kiri (1/3 width)
- Post content di sebelah kanan (2/3 width)
- Responsive: Stack vertical di mobile

### Di Post Detail
- Featured image full width di atas content
- Height: 384px (h-96)
- Object-fit: cover (crop otomatis)

### Jika Tidak Ada Featured Image
- Post tetap ditampilkan normal
- Hanya tanpa gambar

## Fitur
- ✅ **Upload saat create/edit**: Tambah gambar kapan saja
- ✅ **Drag & drop**: Drag file langsung ke area upload
- ✅ **Live preview**: Preview gambar sebelum save
- ✅ **Replace image**: Upload baru otomatis replace lama
- ✅ **Remove image**: Tombol X untuk hapus gambar
- ✅ **Auto delete**: Gambar lama otomatis terhapus
- ✅ **Validation**: Cek ukuran dan format file
- ✅ **Responsive**: Tampilan optimal di semua device

## Storage
- Featured images disimpan di `storage/app/public/posts`
- Accessible via `/storage/posts`
- Otomatis terhapus saat post dihapus

## Tips
1. **Ukuran Optimal**: Gunakan 1200x630px untuk hasil terbaik
2. **Compress**: Compress gambar sebelum upload untuk loading lebih cepat
3. **Format**: JPG untuk foto, PNG untuk grafis dengan transparansi
4. **Alt Text**: Title post otomatis jadi alt text gambar


## User Permissions

### Siapa yang Bisa Membuat Post?
- ✅ **Semua user yang login** bisa membuat blog post
- ✅ **Semua user yang login** bisa upload featured image
- ✅ User hanya bisa edit/delete post mereka sendiri
- ✅ Admin bisa edit/delete semua post

### Cara Membuat Post (User Biasa)
1. Login ke akun Anda
2. Klik "Create Post" di navigation bar
3. Upload featured image (optional)
4. Isi title dan content
5. Centang "Publish immediately" jika ingin langsung publish
6. Klik "Create Post"

### Edit/Delete Post
- **User biasa**: Hanya bisa edit/delete post sendiri
- **Admin**: Bisa edit/delete semua post
- Tombol Edit/Delete muncul di halaman post detail

### Post Visibility
- Published posts: Terlihat oleh semua orang
- Unpublished posts: Hanya terlihat oleh author
- Admin bisa melihat semua post

## Navigation
- **Blog**: Lihat semua published posts
- **Create Post**: Buat post baru (muncul saat login)
- **Dashboard**: Dashboard user
- **Messages**: Lihat approved messages (user biasa)
- **Admin Messages**: Moderate messages (admin only)
- **Users**: Manage user roles (admin only)
