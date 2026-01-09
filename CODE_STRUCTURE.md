# Code Structure Guide - Laravel 12 Stisla

This document explains the codebase structure and how different parts work together.

## 🏗️ Architecture Overview

```
User Request → Routes → Middleware → Controller → Model → Database
                ↓                      ↓
            Validation            View (Blade)
                                      ↓
                                  Response
```

## 📂 Directory Structure Explained

### `/app` - Application Logic

#### `/app/Http/Controllers`
**Purpose:** Handle HTTP requests and return responses

**Key Files:**
- `ProfileController.php` - User profile management
  - Methods: `edit()`, `update()`, `changepassword()`, `password()`
  - Demonstrates: Validation, authentication, hashing
  
- `HomeController.php` - Dashboard and home pages
  
- `HakaksesController.php` - Access rights management
  - Role-based access control example
  
- `ExampleController.php` - Stisla template examples
  - Shows various UI components

**Best Practices:**
```php
// Good: Single Responsibility
public function update(Request $request)
{
    $validated = $request->validate([...]); // Validate
    $user = Auth::user();                   // Get data
    $user->update($validated);              // Update
    return redirect()->back();              // Respond
}

// Avoid: Doing too much in one method
```

#### `/app/Models`
**Purpose:** Represent database tables and relationships

**Key Files:**
- `User.php` - User authentication and data
  - Traits: `HasFactory`, `Notifiable`
  - Properties: `$fillable`, `$hidden`, `casts()`
  - Used for: Login, registration, profile

- `hakakses.php` - Access rights model
  - Uses same table as User (`users`)
  - Focuses on role management

**Model Patterns:**
```php
// Define relationships
public function posts()
{
    return $this->hasMany(Post::class);
}

// Use scopes for queries
public function scopeActive($query)
{
    return $query->where('active', true);
}

// Accessors for computed attributes
public function getFullNameAttribute()
{
    return $this->first_name . ' ' . $this->last_name;
}
```

#### `/app/Notifications`
**Purpose:** Send notifications via email, SMS, etc.

**Key Files:**
- `OtpPasswordResetNotification.php`
  - Sends OTP for password reset
  - Demonstrates: Mail notifications, custom messages

**Notification Structure:**
```php
// 1. Define channels
public function via($notifiable)
{
    return ['mail', 'database']; // Where to send
}

// 2. Build message
public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Your Subject')
        ->line('Message content')
        ->action('Button Text', $url);
}
```

### `/routes` - URL Routing

#### `web.php`
**Purpose:** Define URL patterns and map to controllers

**Structure:**
```php
// Public routes (no auth)
Route::get('/page', [Controller::class, 'method']);

// Protected routes (auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', ...);
    
    // Extra protection (role-based)
    Route::middleware(['superadmin'])->group(function () {
        Route::resource('admin', AdminController::class);
    });
});
```

**Route Types:**
- `GET` - Retrieve data (view pages)
- `POST` - Create new data
- `PUT/PATCH` - Update existing data
- `DELETE` - Remove data

### `/resources` - Views and Assets

#### `/resources/views`
**Purpose:** HTML templates using Blade

**Blade Syntax:**
```blade
{{-- Comments --}}
{{ $variable }}              {{-- Echo (escaped) --}}
{!! $html !!}               {{-- Raw HTML --}}

@if($condition)             {{-- Conditionals --}}
    ...
@endif

@foreach($items as $item)   {{-- Loops --}}
    {{ $item->name }}
@endforeach

@extends('layout')          {{-- Layout inheritance --}}
@section('content')         {{-- Define section --}}
@endsection
```

#### `/resources/css` & `/resources/js`
**Purpose:** Source files for Vite compilation

**Vite Process:**
```
resources/js/app.js  →  Vite  →  public/build/assets/app.js
resources/css/app.css →  Vite  →  public/build/assets/app.css
```

### `/database` - Database Schema

#### `/database/migrations`
**Purpose:** Version control for database structure

**Migration Structure:**
```php
public function up()    // Create/modify tables
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->foreignId('user_id')->constrained();
        $table->timestamps();
    });
}

public function down()  // Rollback changes
{
    Schema::dropIfExists('posts');
}
```

**Common Column Types:**
- `string()` - VARCHAR
- `text()` - TEXT
- `integer()` - INT
- `boolean()` - BOOLEAN
- `timestamps()` - created_at, updated_at
- `foreignId()` - Foreign key

#### `/database/seeders`
**Purpose:** Insert test/default data

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
]);
```

#### `/database/factories`
**Purpose:** Generate fake data for testing

```php
public function definition()
{
    return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password'),
    ];
}
```

### `/config` - Configuration Files

**Key Files:**
- `app.php` - Application settings (name, timezone, locale)
- `database.php` - Database connections
- `mail.php` - Email configuration
- `auth.php` - Authentication settings
- `services.php` - Third-party services

**Usage:**
```php
config('app.name')           // Get config value
config('app.timezone', 'UTC') // With default
```

### `/public` - Public Assets

**What Goes Here:**
- Compiled CSS/JS (from Vite)
- Images, fonts, icons
- index.php (entry point)
- .htaccess (Apache config)

**Important:** Never put sensitive files here!

## 🔄 Request Lifecycle

### 1. Entry Point
```
User requests /profile/edit
    ↓
public/index.php (entry point)
    ↓
bootstrap/app.php (load Laravel)
```

### 2. Routing
```
routes/web.php
    ↓
Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ↓
Checks middleware: ['auth']
```

### 3. Middleware
```
app/Http/Middleware/Authenticate.php
    ↓
Check if user is logged in
    ↓
If yes: continue
If no: redirect to login
```

### 4. Controller
```
ProfileController@edit
    ↓
public function edit()
{
    $user = Auth::user();              // Get user from database
    return view('profile.edit', [       // Load view
        'user' => $user
    ]);
}
```

### 5. View
```
resources/views/profile/edit.blade.php
    ↓
@extends('layouts.app')                // Use layout
    ↓
Display HTML with user data: {{ $user->name }}
    ↓
Return HTML to browser
```

### 6. Response
```
HTML sent to user's browser
    ↓
Browser renders the page
```

## 🔐 Authentication Flow

### Registration
```
1. User fills form → /register (POST)
2. RegisterController validates data
3. Create user: User::create([...])
4. Hash password: Hash::make($password)
5. Auto-login: Auth::login($user)
6. Redirect to dashboard
```

### Login
```
1. User submits credentials → /login (POST)
2. LoginController attempts auth
3. Auth::attempt(['email' => $email, 'password' => $password])
4. If success: create session
5. Redirect to intended page or /home
```

### Password Reset
```
1. User requests reset → /password/email
2. Generate OTP
3. Send OtpPasswordResetNotification
4. User enters OTP
5. Verify and reset password
```

## 📊 Database Queries

### Eloquent Examples

```php
// Find by ID
$user = User::find(1);

// Find or fail (404 if not found)
$user = User::findOrFail(1);

// Get all
$users = User::all();

// Where clause
$admins = User::where('role', 'admin')->get();

// Create
$user = User::create([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// Update
$user->update(['name' => 'Jane']);

// Delete
$user->delete();

// Relationships
$user->posts; // Get user's posts
$post->user;  // Get post's author
```

## 🎨 Blade Components

### Layouts
```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    @yield('content')
</body>
</html>

{{-- profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <h1>Edit Profile</h1>
@endsection
```

### Components
```blade
{{-- Include partial --}}
@include('partials.navbar')

{{-- Pass data --}}
@include('partials.alert', ['type' => 'success', 'message' => 'Saved!'])
```

## 🛡️ Security Best Practices

### 1. Mass Assignment Protection
```php
// Define fillable fields
protected $fillable = ['name', 'email'];

// Now safe from mass assignment attacks
User::create($request->all());
```

### 2. CSRF Protection
```blade
{{-- Always include in forms --}}
<form method="POST">
    @csrf
    ...
</form>
```

### 3. SQL Injection Prevention
```php
// Good: Parameterized (Eloquent does this)
User::where('email', $email)->first();

// Avoid: Raw SQL without binding
DB::raw("SELECT * FROM users WHERE email = '$email'");
```

### 4. XSS Prevention
```blade
{{-- Good: Escaped by default --}}
{{ $user->name }}

{{-- Only use when you trust the content --}}
{!! $trustedHtml !!}
```

## 🧪 Testing

```php
// Feature test example
public function test_user_can_update_profile()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->put('/profile/update', [
            'name' => 'New Name',
            'email' => 'new@example.com'
        ]);
    
    $response->assertRedirect();
    $this->assertEquals('New Name', $user->fresh()->name);
}
```

## 📚 Common Patterns

### Service Pattern
```php
// app/Services/UserService.php
class UserService
{
    public function updateProfile(User $user, array $data)
    {
        // Business logic here
        return $user->update($data);
    }
}

// In controller
public function update(Request $request, UserService $service)
{
    $service->updateProfile(Auth::user(), $request->validated());
}
```

### Repository Pattern
```php
interface UserRepositoryInterface
{
    public function find($id);
    public function create(array $data);
}

class UserRepository implements UserRepositoryInterface
{
    public function find($id)
    {
        return User::find($id);
    }
}
```

## 🎯 Next Steps

After understanding this structure:
1. ✅ Trace a request from route to response
2. ✅ Create your own controller and route
3. ✅ Build a simple CRUD feature
4. ✅ Add validation and error handling
5. ✅ Write tests for your feature

## 📖 Further Reading

- [Laravel Architecture Concepts](https://laravel.com/docs/lifecycle)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templates](https://laravel.com/docs/blade)
- [Validation](https://laravel.com/docs/validation)

---

**Remember:** The best way to learn is by doing. Modify the code, break things, fix them, and learn!
