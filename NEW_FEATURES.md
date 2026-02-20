# New Features Documentation

This document describes the new features that have been added to the Laravel 12 Stisla Admin Template.

## 🎉 New Features

### 1. Activity Log System 📝

Track all user activities and system events with a comprehensive logging system.

**Features:**
- Automatic logging of user activities
- Filter by user, event type, and date range
- Search functionality
- Detailed view of each activity log
- Clear all logs functionality (Admin only)
- IP address and user agent tracking

**Files:**
- Migration: `database/migrations/2026_01_11_000001_create_activity_logs_table.php`
- Model: `app/Models/ActivityLog.php`

**Usage:**
```php
use App\Models\ActivityLog;

// Simple log
ActivityLog::log('User performed an action', 'Subject', 'event_type');

// With model reference
ActivityLog::log('User updated profile', 'Profile', 'updated', $user);

// With additional properties
ActivityLog::log('Custom action', 'Subject', 'custom', null, ['key' => 'value']);
```

**Access:**
- Route: `/activity-logs`
- Permission: Superadmin only

---

### 2. Settings Management 🔧

Manage application settings from the admin panel with a flexible settings system.

**Features:**
- Grouped settings (general, email, social, appearance)
- Multiple input types (text, textarea, number, email, url, boolean, json)
- Add new settings dynamically
- Reset settings to default
- Cached settings for better performance
- Easy retrieval with helper methods

**Files:**
- Migration: `database/migrations/2026_01_11_000002_create_settings_table.php`
- Model: `app/Models/Setting.php`
- Controller: `app/Http/Controllers/SettingController.php`
- Views: `resources/views/settings/index.blade.php`
- Seeder: `database/seeders/SettingSeeder.php`

**Usage:**
```php
use App\Models\Setting;

// Get a setting
$appName = Setting::get('app_name', 'Default Name');

// Set a setting
Setting::set('app_name', 'My Application', 'text');

// Clear cache
Setting::clearCache();
```

**Access:**
- Route: `/settings`
- Permission: Superadmin only

---

### 3. Notification System 🔔

Send and manage notifications to users with a flexible notification system.

**Features:**
- Send notifications to specific users
- Multiple notification types (info, success, warning, danger)
- Mark as read/unread
- Delete notifications
- Clear all notifications
- Notification counter in sidebar
- Action buttons with custom URLs
- Send notifications from admin panel

**Files:**
- Migration: `database/migrations/2026_01_11_000003_create_notifications_table.php`
- Notification Class: `app/Notifications/GeneralNotification.php`
- Controller: `app/Http/Controllers/NotificationController.php`
- Views: `resources/views/notifications/`

**Usage:**
```php
use App\Notifications\GeneralNotification;

// Send notification to a user
$user->notify(new GeneralNotification(
    'Notification Title',
    'Notification message here',
    route('some.route'), // action URL (optional)
    'View Details',      // action button text (optional)
    'info'              // type: info, success, warning, danger
));

// Send to multiple users
$users = User::all();
foreach ($users as $user) {
    $user->notify(new GeneralNotification(...));
}
```

**Access:**
- Route: `/notifications` (All users)
- Route: `/notifications/create` (Admin only - send notifications)

---

### 4. File Manager 📁

Upload, organize, and manage files with a visual file manager.

**Features:**
- Upload multiple files
- Organize files in folders
- File preview for images
- Download files
- Edit file details (name, description, folder)
- Public/private file toggle
- Filter by file type
- Search files
- Automatic file type icons
- File size tracking

**Files:**
- Migration: `database/migrations/2026_01_11_000004_create_files_table.php`
- Model: `app/Models/File.php`
- Controller: `app/Http/Controllers/FileManagerController.php`
- Views: `resources/views/file-manager/index.blade.php`

**Features:**
- Supports images, documents, archives, videos, audio
- Max file size: 10MB per file
- Files stored in: `storage/app/public/uploads/`
- Automatic thumbnail generation for images

**Usage:**
```php
use App\Models\File;

// Get user's files
$files = File::where('user_id', auth()->id())->get();

// Get files in a folder
$files = File::where('folder', '/my-folder')->get();

// Check if file is an image
if ($file->isImage()) {
    // Do something
}

// Get file URL
$url = $file->url;

// Get formatted size
$size = $file->formatted_size; // e.g., "2.5 MB"
```

**Access:**
- Route: `/file-manager`
- Permission: All authenticated users

---

## 📦 Installation & Setup

### 1. Run Migrations

```bash
php artisan migrate
```

This will create the following tables:
- `activity_logs`
- `settings`
- `notifications`
- `files`

### 2. Seed Default Settings

```bash
php artisan db:seed --class=SettingSeeder
```

### 3. Create Storage Link

```bash
php artisan storage:link
```

This is required for the File Manager to display uploaded files.

### 4. Clear Cache (Optional)

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🚀 Quick Start

### Activity Logging

Automatically log user actions in your controllers:

```php
use App\Models\ActivityLog;

public function store(Request $request)
{
    $item = Item::create($request->validated());

    ActivityLog::log(
        'New item created: ' . $item->name,
        'Items Management',
        'created',
        $item
    );

    return redirect()->back();
}

// Convenience methods are also available:
ActivityLog::logLogin($user);
ActivityLog::logLogout($user);
ActivityLog::logProfileUpdate($user);
ActivityLog::logPasswordChange($user);
```

### Send Notification

Send notifications from your code:

```php
use App\Notifications\GeneralNotification;

auth()->user()->notify(new GeneralNotification(
    'Welcome!',
    'Welcome to our application',
    route('home'),
    'Go to Dashboard',
    'success'
));
```

### Use Settings

Access settings anywhere in your application:

```php
use App\Models\Setting;

// In your blade templates
{{ Setting::get('app_name') }}

// In your controllers
$contactEmail = Setting::get('contact_email');
```

---

## 🔐 Permissions

### Superadmin Only:
- Activity Logs (view, delete, clear)
- Settings Management (view, edit, create, delete)
- Send Notifications (admin panel)

### All Authenticated Users:
- View own notifications
- Mark notifications as read/unread
- Delete own notifications
- File Manager (upload, view, manage own files)

---

## 📝 Menu Structure

The new menu items have been added to the sidebar:

**Features Section:**
- Notifications (with unread counter badge)
- File Manager

**Admin Tools Section (Superadmin only):**
- Activity Logs
- Settings

---

## 🎨 Customization

### Customize Notification Types

Edit `app/Notifications/GeneralNotification.php` to add more notification types or modify existing ones.

### Customize Activity Log Events

Add more event types in your models or controllers using the `ActivityLog::log()` method.

### Add More Settings Groups

Edit `database/seeders/SettingSeeder.php` to add more setting groups and default values.

### Customize File Upload Limits

Edit `app/Http/Controllers/FileManagerController.php` in the `upload()` method to change max file size or allowed file types.

---

## 🐛 Troubleshooting

### File uploads not working
- Make sure storage link is created: `php artisan storage:link`
- Check folder permissions for `storage/app/public/`
- Verify `FILESYSTEM_DISK=public` in your `.env` file

### Settings not updating
- Clear cache: `php artisan cache:clear`
- Check if Settings table is properly migrated

### Notifications not showing
- Run migration: `php artisan migrate`
- Make sure the User model uses `Notifiable` trait

---

## 📚 API Endpoints

### Activity Logs
- `GET /activity-logs` - List all logs
- `GET /activity-logs/{id}` - View log details
- `DELETE /activity-logs/{id}` - Delete log
- `DELETE /activity-logs` - Clear all logs

### Settings
- `GET /settings` - View all settings
- `PUT /settings` - Update settings
- `POST /settings` - Create new setting
- `POST /settings/reset` - Reset settings

### Notifications
- `GET /notifications` - List notifications
- `POST /notifications/{id}/mark-as-read` - Mark as read
- `POST /notifications/mark-all-read` - Mark all as read
- `DELETE /notifications/{id}` - Delete notification
- `DELETE /notifications` - Delete all notifications
- `GET /notifications/create` - Send notification form (admin)
- `POST /notifications/send` - Send notification (admin)

### File Manager
- `GET /file-manager` - List files
- `POST /file-manager/upload` - Upload files
- `GET /file-manager/{id}/download` - Download file
- `PUT /file-manager/{id}` - Update file details
- `DELETE /file-manager/{id}` - Delete file
- `POST /file-manager/create-folder` - Create folder

---

## 🔄 Future Enhancements

Potential features to add:
- Email notifications
- Real-time notifications with Pusher/Broadcasting
- File sharing between users
- Advanced file permissions
- Export activity logs to CSV/Excel
- Setting import/export
- Notification templates
- File versioning

---

## 📖 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Stisla Admin Template](https://getstisla.com)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel File Storage](https://laravel.com/docs/filesystem)

---

**Created:** January 11, 2026
**Last Updated:** February 20, 2026
**Version:** 1.1.0
**Laravel Version:** 12.x
