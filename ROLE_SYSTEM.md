# Role System Documentation

## Overview
Sistem role untuk membedakan akses antara Admin dan User biasa.

## Roles
- **admin**: Full access ke semua fitur termasuk user management dan message moderation
- **user**: Akses terbatas, hanya bisa melihat approved messages

## Default Accounts
```
Admin:
Email: admin@example.com
Password: password

Regular User:
Email: user@example.com
Password: password
```

## Features

### Admin Features
- `/admin/messages` - Moderate messages (approve/delete)
- `/admin/users` - Manage user roles
- `/admin/posts/*` - Create, edit, delete posts

### User Features
- `/messages` - View approved messages only
- `/` - View published posts

## Routes
```php
// Public routes
GET / - Blog index
GET /post/{slug} - View post

// Authenticated routes
GET /messages - User messages (approved only)

// Admin routes (requires 'admin' middleware)
GET /admin/messages - All messages with moderation
PATCH /admin/messages/{message}/approve - Approve message
DELETE /admin/messages/{message} - Delete message
GET /admin/users - User management
PATCH /admin/users/{user}/role - Update user role
```

## Database Changes
- Added `role` column to `users` table (enum: 'user', 'admin', default: 'user')

## Middleware
- `IsAdmin` - Checks if authenticated user has admin role
- Returns 403 if not admin

## Usage
Admin dapat mengubah role user lain melalui halaman `/admin/users`


## Profile Features

### Avatar & Bio
- Users can upload profile pictures (JPG, PNG, GIF up to 2MB)
- Default avatar generated using UI Avatars if no upload
- Bio field for user description (max 500 characters)

### Public Profile
- View any user's public profile at `/profile/{user}`
- Shows user avatar, name, email, bio
- Lists all published posts by the user
- Post count and join date

### Profile Display
- Avatar shown in navigation dropdown
- Avatar displayed on blog posts (index and show pages)
- Clickable avatars link to user profile
- Avatar preview when uploading new image

### Storage
- Avatars stored in `storage/app/public/avatars`
- Accessible via `/storage/avatars` (symlink created)
- Old avatars automatically deleted on new upload
