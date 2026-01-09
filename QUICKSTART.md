# Quick Start Guide - Laravel 12 Stisla

Welcome to Laravel 12 Stisla Template! This guide will get you started in minutes.

## 🚀 Installation (5 Minutes)

### Step 1: Clone & Navigate
```bash
git clone https://github.com/vickymaulana/laravel12-stisla.git
cd laravel12-stisla
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file:
```env
DB_DATABASE=laravel_stisla
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Run Migrations
```bash
php artisan migrate
```

### Step 6: Build & Serve
```bash
# Terminal 1: Frontend assets
npm run dev

# Terminal 2: Laravel server
php artisan serve
```

Visit: **http://localhost:8000** 🎉

## 📝 First Steps

1. **Register Account**: `/register`
2. **Explore Dashboard**: After login, you'll see the dashboard
3. **Edit Profile**: Click your name → Edit Profile
4. **Try Examples**: Check the sidebar for template examples

## 🎓 Learning Path

1. **Week 1**: Routes & Controllers → [LEARNING.md](LEARNING.md)
2. **Week 2**: Database & Models
3. **Week 3**: Views & Authentication
4. **Week 4**: Advanced Features

## 📚 Documentation Files

- **[README.md](README.MD)** - Full documentation
- **[LEARNING.md](LEARNING.md)** - Step-by-step learning guide
- **[CONTRIBUTING.md](CONTRIBUTING.md)** - How to contribute
- **[CHANGELOG.md](CHANGELOG.md)** - What's new

## 🆘 Need Help?

**Common Issues:**
- Permission errors? Run: `chmod -R 775 storage bootstrap/cache`
- Assets not loading? Run: `npm run build`
- Database errors? Check your `.env` file

**Get Support:**
- Read the [README.md](README.MD)
- Check [Laravel Docs](https://laravel.com/docs)
- Open an [Issue](https://github.com/vickymaulana/laravel12-stisla/issues)

## ✨ What's Included?

### Features
- ✅ Authentication (Login/Register)
- ✅ User Profile Management
- ✅ Role-based Access Control
- ✅ Password Reset with OTP
- ✅ Responsive Dashboard
- ✅ 12+ Example Pages

### Tech Stack
- Laravel 12 (Latest)
- Bootstrap 5.3.3
- Vite 6.0.5
- PHP 8.2+

## 🎯 Quick Commands

```bash
# Development
php artisan serve          # Start server
npm run dev               # Build assets (watch mode)

# Database
php artisan migrate       # Run migrations
php artisan migrate:fresh # Fresh migration
php artisan tinker        # Laravel REPL

# Maintenance
php artisan cache:clear   # Clear cache
composer dump-autoload    # Reload classes
./vendor/bin/pint         # Fix code style

# Production
npm run build             # Build for production
php artisan optimize      # Optimize Laravel
```

## 🔐 Default Routes

| Route | Purpose | Auth Required |
|-------|---------|---------------|
| `/` | Welcome page | No |
| `/register` | User registration | No |
| `/login` | User login | No |
| `/home` | Dashboard | Yes |
| `/profile/edit` | Edit profile | Yes |
| `/hakakses` | Access management | Yes (Superadmin) |

## 🎨 Template Examples

Explore these pages to see Stisla components:
- `/table-example` - DataTables
- `/chart-example` - Charts & graphs
- `/form-example` - Form components
- `/map-example` - Google Maps
- `/calendar-example` - Event calendar
- `/gallery-example` - Image gallery
- And more!

## 📖 Next Steps

After setup:
1. 🎓 Follow the [LEARNING.md](LEARNING.md) guide
2. 🔍 Explore the example pages
3. 💻 Try modifying code
4. 🚀 Build your own feature
5. 🤝 Contribute back!

---

**Happy coding!** 💻✨

For detailed documentation, see [README.md](README.MD)
