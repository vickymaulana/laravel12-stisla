# Laravel 12 with Stisla Admin Template 🚀

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

A modern, production-ready Laravel 12 admin panel template integrated with the beautiful Stisla Bootstrap 5 theme. Perfect for learning Laravel development or kickstarting your next web application!

## 📋 Table of Contents
- [Features](#-features)
- [Demo](#-demo)
- [Tech Stack](#-tech-stack)
- [Prerequisites](#-prerequisites)
- [Quick Start](#-quick-start)
- [Project Structure](#-project-structure)
- [Learning Resources](#-learning-resources)
- [Common Tasks](#-common-tasks)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)
- [Contributors](#-contributors)

## ✨ Features

### Core Functionality
- ✅ **Laravel 12** - Latest version with modern PHP 8.2+
- ✅ **Authentication System** - Complete auth with Laravel UI
- ✅ **User Profile Management** - Edit profile & change password
- ✅ **Role-based Access Control** - Superadmin middleware example
- ✅ **OTP Password Reset** - Secure password recovery via email
- ✅ **Responsive Design** - Mobile-first approach with Bootstrap 5.3

### UI Components & Examples
- 📊 **Dashboard** - Modern admin dashboard
- 📋 **Data Tables** - Interactive tables with sorting and filtering
- 📈 **Charts** - Beautiful data visualization examples
- 📝 **Forms** - Advanced form components and validation
- 🗺️ **Maps** - Google Maps integration
- 📅 **Calendar** - Event calendar implementation
- 🖼️ **Gallery** - Image gallery with lightbox
- ✔️ **Todo List** - Task management example
- 📞 **Contact Page** - Contact form implementation
- 📰 **News & Blog** - Content management examples

## 🎯 Demo

### Screenshots

| Register | Login | Dashboard |
|----------|-------|-----------|
| ![Register](img/register.png) | ![Login](img/login.png) | ![Dashboard](img/dashboard.png) |

| Profile Edit | Blank Page |
|--------------|------------|
| ![Edit](img/edit.png) | ![Blank](img/blank.png) |

## 🛠️ Tech Stack

### Backend
- **PHP** 8.2+
- **Laravel** 12.x
- **Laravel UI** 4.7 - Authentication scaffolding
- **Laravel Tinker** - REPL for Laravel

### Frontend
- **Bootstrap** 5.3.3
- **Vite** 6.0.5 - Modern build tool
- **Sass** 1.83.0 - CSS preprocessor
- **Axios** 1.7.9 - HTTP client
- **Popper.js** 2.11.8 - Tooltip & popover positioning

### Development Tools
- **Laravel Pint** - Code style fixer
- **Laravel Sail** - Docker development environment
- **PHPUnit** 11.5 - Testing framework
- **Faker** - Test data generator
- **Laravel Migrations Generator** - Reverse migrations

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2 ([Download](https://www.php.net/downloads))
- **Composer** ([Download](https://getcomposer.com/download/))
- **Node.js** >= 18 ([Download](https://nodejs.org/))
- **npm** or **yarn** (comes with Node.js)
- **MySQL** or **PostgreSQL** (or any Laravel-supported database)
- **Git** ([Download](https://git-scm.com/downloads))

### Checking Your Environment

```bash
# Check PHP version
php -v

# Check Composer
composer --version

# Check Node.js & npm
node -v
npm -v
```

## 🚀 Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/vickymaulana/laravel12-stisla.git
cd laravel12-stisla
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_stisla
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Build Frontend Assets

```bash
# Development mode (with hot reload)
npm run dev

# Or production build
npm run build
```

### 8. Start the Development Server

```bash
php artisan serve
```

Visit **http://localhost:8000** in your browser! 🎉

### 9. Register Your First User

1. Navigate to `http://localhost:8000/register`
2. Fill in your details:
   - **Name**: Your full name
   - **Email**: Your email address
   - **Password**: Minimum 8 characters
   - **Confirm Password**: Must match password
3. Click "Register"
4. You'll be automatically logged in and redirected to the dashboard

## 📁 Project Structure

```
laravel12-stisla/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Application controllers
│   │   │   ├── ProfileController.php    # User profile management
│   │   │   ├── HomeController.php       # Dashboard controller
│   │   │   ├── HakaksesController.php   # Access rights management
│   │   │   └── ExampleController.php    # Template examples
│   │   └── Middleware/          # Custom middleware
│   │
│   ├── Models/                  # Eloquent models
│   │   ├── User.php            # User model with auth
│   │   └── hakakses.php        # Access rights model
│   │
│   └── Notifications/           # Email notifications
│       └── OtpPasswordResetNotification.php
│
├── config/                      # Configuration files
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
│
├── public/                     # Public assets
│   ├── assets/                # Stisla CSS files
│   ├── css/                   # Custom stylesheets
│   ├── js/                    # JavaScript files
│   └── library/               # Third-party libraries
│
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Source CSS/Sass
│   └── js/                    # Source JavaScript
│
├── routes/
│   ├── web.php               # Web routes (main routing file)
│   └── console.php           # Console commands
│
├── tests/                     # Automated tests
│   ├── Feature/              # Feature tests
│   └── Unit/                 # Unit tests
│
├── .env.example              # Environment variables template
├── composer.json             # PHP dependencies
├── package.json              # Node.js dependencies
└── vite.config.js           # Vite configuration
```

## 📚 Learning Resources

### Key Concepts Covered

This template demonstrates the following Laravel concepts:

#### 1. **Authentication & Authorization**
- User registration and login
- Password reset with OTP
- Middleware protection for routes
- Role-based access control (superadmin middleware)

#### 2. **Database & Eloquent ORM**
- Model creation and relationships
- Mass assignment protection
- Database migrations
- Model factories for testing

#### 3. **Controllers & Routing**
- RESTful resource controllers
- Route grouping and middleware
- Named routes for easy URL generation

#### 4. **Views & Blade Templates**
- Blade templating engine
- Layout inheritance
- Component reusability
- Form handling and validation

#### 5. **Form Validation**
- Request validation rules
- Custom error messages
- Server-side validation

#### 6. **Email Notifications**
- Custom notification classes
- Mail configuration
- Queue-able notifications

### Understanding the Code

#### Profile Management Example

The `ProfileController.php` demonstrates:
- ✅ How to validate user input
- ✅ How to get the authenticated user
- ✅ How to update database records
- ✅ How to redirect with flash messages

#### Route Protection Example

The `web.php` file shows:
- ✅ How to protect routes with middleware
- ✅ How to stack multiple middleware
- ✅ How to create route groups

### Recommended Learning Path

1. **Start with Routes** - `routes/web.php`
   - Understand how URLs map to controllers
   - Learn about route naming and grouping

2. **Explore Controllers** - `app/Http/Controllers/`
   - See how controllers handle requests
   - Study validation and business logic

3. **Study Models** - `app/Models/`
   - Learn about Eloquent ORM
   - Understand model relationships

4. **Review Views** - `resources/views/`
   - See how Blade templates work
   - Learn about layout inheritance

5. **Practice with Examples**
   - Try the example pages (charts, tables, forms)
   - Modify them to create your own features

## 🔧 Common Tasks

### Create a New Controller

```bash
php artisan make:controller YourController
```

### Create a New Model with Migration

```bash
php artisan make:model YourModel -m
```

### Run Tests

```bash
php artisan test
```

### Clear Application Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Code Style Fixing

```bash
./vendor/bin/pint
```

## 🐛 Troubleshooting

### Common Issues

**Issue**: "Permission denied" errors
```bash
# Solution: Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

**Issue**: "Class not found" errors
```bash
# Solution: Regenerate autoload files
composer dump-autoload
```

**Issue**: Assets not loading
```bash
# Solution: Rebuild assets
npm run build
php artisan optimize:clear
```

**Issue**: Database connection errors
```bash
# Solution: Check .env database credentials
# Make sure MySQL/PostgreSQL is running
```

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. **Open** a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Run `./vendor/bin/pint` before committing
- Write meaningful commit messages
- Add comments for complex logic
- Update documentation for new features

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👥 Contributors

### Project Maintainer
- **Vicky Maulana** - [GitHub](https://github.com/vickymaulana)

### Special Thanks

I extend my gratitude to all the interns at LLDIKTI 2 Division of Information System Development for their contributions and support:

- [Ahmad Dimas Aldian Al-furqon](https://github.com/anqois)
- [Abdillah Khalid](https://github.com/KhalidUnsri)
- [Haikal Tirta Albanna](https://github.com/HaikalAlbanna)
- [Meta Berliana](https://github.com/Metabrln)
- [Imelda Triadmajaya](https://github.com/imeldatriajaya)
- [Hilwa Izzatinnafisah](https://github.com/ksnwaa)
- [Triyana Sugiyarti](https://github.com/TriyanaSgi)
- [Adelia Isni Hendrawan Putri](https://github.com/lilisky07)
- [Siti Nur Azizah](https://github.com/sukasukajija)
- [M. Husaini Hasyim](https://github.com/son-alone)
- [Andre Satriawan](https://github.com/andresa11satriawan)
- [Lathifah Putri Aresti](https://github.com/lathifahputri)
- [Sisca Amelia](https://github.com/siscaamelia)
- [M. Denny Tri Lisandi](https://github.com/Koutsura)

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com) - The PHP framework for web artisans
- [Stisla](https://getstisla.com) - Free Bootstrap Admin Template
- [Bootstrap](https://getbootstrap.com) - The world's most popular CSS framework

## 📞 Support

If you encounter any issues or have questions:

1. Check the [Laravel Documentation](https://laravel.com/docs)
2. Review the [existing issues](https://github.com/vickymaulana/laravel12-stisla/issues)
3. Create a new issue with detailed information
4. Join the discussion in pull requests

---

**Happy Coding! 💻✨**

Made with ❤️ by the Laravel Community
