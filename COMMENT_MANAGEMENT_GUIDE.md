# Comment Management Guide

## Fitur Edit & Delete Comment

### Overview
User sekarang bisa edit dan delete comment mereka sendiri, seperti di YouTube, Instagram, dan platform social media lainnya.

## Features

### 1. Edit Comment
**Who Can Edit**:
- ✅ Comment owner (user yang membuat comment)
- ❌ Other users (tidak bisa edit comment orang lain)
- ❌ Admin (belum ada fitur admin edit)

**How to Edit**:
1. Lihat comment Anda
2. Klik icon pensil (edit) di sebelah kanan
3. Textarea muncul dengan text comment
4. Edit text
5. Klik "Save" atau "Cancel"

**Features**:
- Inline editing (no page reload)
- Cancel button (revert changes)
- Validation (cannot be empty)
- "(edited)" label appears after edit
- Instant update

### 2. Delete Comment
**Who Can Delete**:
- ✅ Comment owner
- ❌ Other users
- ❌ Admin (belum ada fitur admin delete)

**How to Delete**:
1. Lihat comment Anda
2. Klik icon trash (delete) di sebelah kanan
3. Confirm deletion
4. Comment removed instantly

**Features**:
- Confirmation dialog
- Instant removal
- No page reload
- Cascade delete (likes also deleted)

## UI/UX

### Button Visibility
**Own Comments**:
- Like button (heart icon)
- Edit button (pencil icon)
- Delete button (trash icon)

**Other's Comments**:
- Like button only
- No edit/delete buttons

**Guest View**:
- Like count only
- No buttons

### Visual Indicators
**Edited Comment**:
- Shows "(edited)" label after timestamp
- Gray color, small text
- Indicates comment was modified

**Edit Mode**:
- Textarea replaces comment text
- Save and Cancel buttons appear
- Focus on textarea automatically

### Icons
- **Edit**: Pencil icon (blue on hover)
- **Delete**: Trash icon (red on hover)
- **Like**: Heart icon (red when liked)

## Technical Details

### Backend (MessageManagementController)

**Update Method**:
```php
public function update(Request $request, Message $message)
{
    // Check ownership
    if ($message->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Validate
    $request->validate([
        'message' => 'required|string|max:2000'
    ]);

    // Update
    $message->update(['message' => $request->message]);

    return response()->json([
        'success' => true,
        'message' => $message->message
    ]);
}
```

**Delete Method**:
```php
public function destroy(Message $message)
{
    // Check ownership
    if ($message->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Delete (cascade deletes likes)
    $message->delete();

    return response()->json(['success' => true]);
}
```

### Frontend (JavaScript)

**Edit Flow**:
1. Click edit button
2. Hide comment text
3. Show textarea with current text
4. User edits
5. Click save
6. AJAX request to update
7. Update UI with new text
8. Refresh component (show "edited" label)

**Delete Flow**:
1. Click delete button
2. Confirm dialog
3. AJAX request to delete
4. Refresh component (remove comment)

### Routes
```php
// Authenticated routes
Route::patch('/messages/{message}', [MessageManagementController::class, 'update']);
Route::delete('/messages/{message}', [MessageManagementController::class, 'destroy']);
```

## Security

### Authorization
- Backend checks `user_id === auth()->id()`
- Returns 403 if unauthorized
- Frontend hides buttons for non-owners

### Validation
- Message required
- Max 2000 characters
- Cannot be empty
- XSS protection (Laravel escaping)

### CSRF Protection
- CSRF token in all requests
- Laravel middleware validation

## Database

### Updated_at Timestamp
- Automatically updated on edit
- Used to show "(edited)" label
- Comparison: `created_at != updated_at`

### Cascade Delete
- Deleting message also deletes:
  - Associated likes
  - (Future: replies, notifications)

## User Experience

### Instant Feedback
- No page reload
- Smooth transitions
- Loading states (optional)
- Error handling

### Clear Actions
- Icon buttons (intuitive)
- Hover effects (visual feedback)
- Confirmation (prevent accidents)
- Cancel option (undo changes)

### Accessibility
- Keyboard accessible
- Screen reader friendly
- Clear button labels
- Focus management

## Testing

### Test Edit
1. Login
2. Post a comment
3. Click edit button
4. ✅ Textarea appears
5. Change text
6. Click save
7. ✅ Text updates
8. ✅ "(edited)" label appears

### Test Delete
1. Login
2. Post a comment
3. Click delete button
4. ✅ Confirmation dialog
5. Confirm
6. ✅ Comment removed
7. Check database
8. ✅ Record deleted

### Test Authorization
1. Login as User A
2. User B posts comment
3. User A views comment
4. ✅ No edit/delete buttons
5. Try direct API call
6. ✅ 403 Unauthorized

## Edge Cases

### Empty Message
- Validation prevents empty save
- Alert shown to user
- Edit mode stays active

### Network Error
- Error caught and logged
- Alert shown to user
- UI reverts to original state

### Concurrent Edits
- Last edit wins
- No conflict resolution (yet)
- Refresh shows latest version

## Best Practices

### 1. Always Check Ownership
```php
if ($message->user_id !== auth()->id()) {
    return response()->json(['error' => 'Unauthorized'], 403);
}
```

### 2. Validate Input
```php
$request->validate([
    'message' => 'required|string|max:2000'
]);
```

### 3. Handle Errors
```javascript
.catch(error => {
    console.error('Error:', error);
    alert('Failed to update message');
});
```

### 4. Confirm Destructive Actions
```javascript
if (!confirm('Are you sure?')) {
    return;
}
```

### 5. Refresh Component
```javascript
$wire.$refresh(); // Show updated data
```

## Future Enhancements

### Admin Features
- [ ] Admin can edit any comment
- [ ] Admin can delete any comment
- [ ] Bulk delete
- [ ] Comment moderation

### Advanced Features
- [ ] Edit history
- [ ] Undo delete (soft delete)
- [ ] Report comment
- [ ] Pin comment
- [ ] Highlight comment

### UX Improvements
- [ ] Inline validation
- [ ] Character counter
- [ ] Auto-save draft
- [ ] Keyboard shortcuts (Ctrl+Enter to save)

## Conclusion

Comment management sekarang lengkap dengan:
- ✅ Edit own comments
- ✅ Delete own comments
- ✅ Inline editing (no reload)
- ✅ Instant updates
- ✅ Proper authorization
- ✅ Clear UI/UX
- ✅ Like YouTube/Instagram

User experience professional dan intuitive!
