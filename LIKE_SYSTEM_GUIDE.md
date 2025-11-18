# Like System Guide

## Fitur Like

### Like untuk Post
- ✅ User bisa like/unlike post
- ✅ Like count ditampilkan di post detail dan index
- ✅ Heart icon berubah warna saat liked (merah)
- ✅ Real-time update tanpa reload page
- ✅ Guest bisa lihat like count tapi tidak bisa like

### Like untuk Comment/Message
- ✅ User bisa like/unlike message
- ✅ Like count ditampilkan di setiap message
- ✅ Heart icon berubah warna saat liked (merah)
- ✅ Real-time update tanpa reload page
- ✅ Guest bisa lihat like count tapi tidak bisa like

## Cara Menggunakan

### Like Post
1. Login ke akun Anda
2. Buka halaman post detail
3. Klik tombol heart di pojok kanan atas (dekat author info)
4. Like count akan update otomatis
5. Klik lagi untuk unlike

### Like Message/Comment
1. Login ke akun Anda
2. Scroll ke bagian comments di post detail
3. Setiap message punya tombol heart kecil di pojok kanan
4. Klik untuk like/unlike
5. Like count update otomatis

## Tampilan

### Post Detail
- **Like Button**: Pojok kanan atas, sejajar dengan author info
- **Liked State**: Background merah muda, icon merah, filled heart
- **Unliked State**: Background abu-abu, icon abu-abu, outline heart
- **Guest View**: Hanya tampil like count, tidak ada button

### Post Index (Homepage)
- **Like Count**: Ditampilkan di bawah title
- **Icon**: Heart outline dengan jumlah likes
- **No Button**: Di index hanya tampil count, tidak bisa like

### Messages/Comments
- **Like Button**: Pojok kanan setiap message
- **Liked State**: Text merah, filled heart
- **Unliked State**: Text abu-abu, outline heart
- **Guest View**: Hanya tampil like count

## Database Structure

### likes table
```
- id
- user_id (foreign key to users)
- likeable_id (polymorphic)
- likeable_type (polymorphic: Post or Message)
- created_at, updated_at
- unique constraint: user_id + likeable_id + likeable_type
```

### Polymorphic Relationship
- Satu tabel `likes` untuk Post dan Message
- Menggunakan `likeable_id` dan `likeable_type`
- Prevent duplicate likes dengan unique constraint

## API Endpoints

### Like Post
```
POST /posts/{post}/like
Response: { "liked": true/false, "likes_count": 10 }
```

### Like Message
```
POST /messages/{message}/like
Response: { "liked": true/false, "likes_count": 5 }
```

## Features

### Toggle Like
- Klik sekali: Like
- Klik lagi: Unlike
- Tidak bisa like lebih dari sekali (unique constraint)

### Real-time Update
- AJAX request tanpa reload page
- Update UI instantly
- Update like count
- Change icon color and fill

### Guest Handling
- Guest bisa lihat like count
- Guest tidak bisa like (button tidak muncul)
- Redirect ke login jika diperlukan

### Permissions
- Semua authenticated user bisa like
- User bisa unlike post/message yang sudah di-like
- Tidak ada batasan jumlah like per user

## UI/UX

### Visual Feedback
- **Hover**: Button berubah warna saat hover (jika belum liked)
- **Liked**: Background merah muda, icon merah filled
- **Unliked**: Background abu-abu, icon outline
- **Transition**: Smooth color transition

### Icon
- Heart icon dari Heroicons
- Outline saat unliked
- Filled saat liked
- Size: 20px (post), 16px (message)

### Count Display
- Angka di sebelah icon
- Update real-time
- Format: "10" (tidak ada "likes" text di message)

## Tips
1. **Like Count**: Bisa dilihat tanpa login
2. **Toggle**: Klik berkali-kali untuk like/unlike
3. **Real-time**: Tidak perlu refresh page
4. **Multiple Likes**: Bisa like banyak post dan message
5. **Unlike**: Klik lagi untuk unlike

## Technical Details

### Models
- `Like` model dengan polymorphic relationship
- `Post` model: `likes()`, `isLikedBy()`, `likesCount()`
- `Message` model: `likes()`, `isLikedBy()`, `likesCount()`

### Controller
- `LikeController`: Handle toggle like untuk Post dan Message
- Return JSON response dengan liked status dan count

### JavaScript
- Fetch API untuk AJAX request
- Update DOM elements (button, count, icon)
- Handle success and error states

### Security
- CSRF token required
- Authentication required
- Unique constraint prevents duplicate likes


## Update: Comment System dengan Avatar

### Fitur Baru Comment
- ✅ **Auto-fill**: Nama dan email otomatis terisi untuk user yang login
- ✅ **Avatar Display**: Setiap comment menampilkan avatar user
- ✅ **Profile Link**: Klik avatar atau nama untuk ke profile
- ✅ **Guest Comments**: Guest tetap bisa comment dengan isi nama manual
- ✅ **User Identification**: Comment dari user terdaftar vs guest dibedakan

### Tampilan Comment

#### Authenticated User
- Avatar user ditampilkan (clickable ke profile)
- Nama user (clickable ke profile)
- Tidak perlu isi nama/email lagi
- Info "Posting as yourself" ditampilkan

#### Guest User
- Avatar default dengan initial nama
- Harus isi nama (optional)
- Harus isi email (optional)
- Nama tidak clickable

### Comment Structure
```
[Avatar] [Name] [Time] [Like Button]
         [Message Text]
```

### Like pada Comment
- Bisa like comment sendiri
- Bisa like comment orang lain
- Toggle like/unlike
- Real-time update

### Database Changes
- Added `user_id` to messages table (nullable)
- Foreign key to users table
- Cascade delete when user deleted

### Benefits
1. **Better UX**: User tidak perlu isi nama berulang
2. **Identity**: Jelas siapa yang comment
3. **Profile Integration**: Link ke profile user
4. **Avatar**: Visual identity untuk setiap comment
5. **Consistency**: Sama seperti social media modern
