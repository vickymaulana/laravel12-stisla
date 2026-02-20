# Laravel 12 with Stisla Admin Template

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

A production-ready Laravel 12 admin template using Stisla UI. This project is designed for rapid project bootstrap, learning Laravel fundamentals, and building real admin features with practical examples.

## Table of Contents
- [Overview](#overview)
- [Core Features](#core-features)
- [Advanced Features](#advanced-features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Password Reset Modes](#password-reset-modes)
- [Quick Tour Routes](#quick-tour-routes)
- [Generator Commands](#generator-commands)
- [Project Structure](#project-structure)
- [Testing and Quality](#testing-and-quality)
- [CI Pipeline](#ci-pipeline)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)
- [Contributors](#contributors)
- [Acknowledgments](#acknowledgments)

## Overview
This repository extends the default Laravel application skeleton with:
- Stisla-based admin layout and example pages
- Authentication flows (including optional OTP-hardening for password reset)
- Role-based access middleware (`superadmin`)
- File manager, notifications, activity logs, and dynamic settings
- Starter code generators for CRUD and seeder/factory scaffolding
- Clean code architecture with proper validation, consistent conventions, and full English localization

The goal is to reduce boilerplate so developers can start building business features faster.

## Core Features
- Laravel 12 + PHP 8.2+
- Authentication using Laravel UI
- User profile management
- Role access example (`superadmin` middleware)
- Responsive admin layout
- Route grouping by domain for readability and maintenance

## Advanced Features
- Activity Log System (`/activity-logs`)
  - Track user/system events
  - Filter by user, event, date, and keyword
  - Safe clear with explicit confirmation and optional retention days

- Settings Management (`/settings`)
  - Grouped application settings from admin panel
  - Type-aware input handling (text, boolean, email, url, json, etc.)

- Notifications (`/notifications`)
  - List, mark as read, mark all read, delete
  - Admin send feature
  - AJAX endpoints:
    - `/notifications/unread-count`
    - `/notifications/recent`

- File Manager (`/file-manager`)
  - Upload/download/update/delete files with ownership checks
  - Folder organization with path normalization
  - Basic security hardening for folder traversal prevention

## Tech Stack
### Backend
- PHP 8.2+
- Laravel 12.x
- Laravel UI
- PHPUnit
- Laravel Pint

### Frontend
- Bootstrap 5 (via npm package)
- Vite
- Sass
- Axios

### Notes
- Legacy Stisla view attributes are shimmed in layout for compatibility while using modern Vite assets.

## Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- npm
- MySQL/PostgreSQL/SQLite
- Git

## Installation
```bash
git clone https://github.com/vickymaulana/laravel12-stisla.git
cd laravel12-stisla
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

Open: `http://localhost:8000`

## Configuration
Key defaults in `.env.example`:
```env
PASSWORD_RESET_METHOD=token
PASSWORD_RESET_OTP_EXPIRE=10
PASSWORD_RESET_OTP_MAX_ATTEMPTS=5
```

Other important setup:
- Configure DB credentials (`DB_*`)
- Configure mail (`MAIL_*`) if using OTP mode

Superadmin setup example (after registration):
```bash
php artisan tinker
```
```php
App\Models\User::where('email', 'your@email.com')->update(['role' => 'superadmin']);
```

## Password Reset Modes
### 1) Token Mode (default)
- Uses Laravel standard password reset token flow.

### 2) OTP Mode (optional)
- Requires valid reset token + OTP code.
- OTP is time-limited.
- Invalid attempts are rate-limited.
- OTP state is invalidated after successful reset.

Set mode in `.env`:
```env
PASSWORD_RESET_METHOD=otp
```

## Quick Tour Routes
After login, use `/quick-tour` to navigate key features quickly.

Recommended routes:
- `/home`
- `/profile/edit`
- `/table-example`
- `/form-example`
- `/notifications`
- `/file-manager`
- `/settings` (superadmin)
- `/activity-logs` (superadmin)

## Generator Commands
### Seeder + Factory
```bash
php artisan make:seeder-factory Product
```

### CRUD with Stisla views
```bash
php artisan make:crud-stisla Product
```

Supported options include custom fields and excluded fields.

## Project Structure
```text
app/
  Console/Commands/           # Custom generators
  Http/Controllers/           # Feature controllers
  Http/Controllers/Auth/      # Authentication controllers
  Http/Middleware/            # Access middleware
  Models/                     # Eloquent models
  Notifications/              # Notification classes

config/
  auth.php                    # Auth + OTP password reset config

resources/
  views/                      # Blade templates
  css/                        # Vite CSS entry
  js/                         # Vite JS entry

routes/
  web.php                     # Main route definitions

database/
  migrations/                 # Schema
  seeders/                    # Seed data
  factories/                  # Factories

tests/
  Feature/                    # Feature tests
  Unit/                       # Unit tests
```

## Testing and Quality
Run locally:
```bash
php artisan route:list --except-vendor
php artisan test
npm run build
```

## CI Pipeline
GitHub Actions workflow: `.github/workflows/ci.yml`

Pipeline covers:
- dependency install
- app bootstrap + migrate
- route integrity check
- test suite
- frontend build

## Troubleshooting
### `php artisan route:list` fails
- Check syntax/import errors in custom controllers.

### Password reset/OTP issues
- Verify `PASSWORD_RESET_METHOD` and `MAIL_*` settings.
- Ensure reset link token is valid and not expired.

### File manager cannot display files
- Run `php artisan storage:link`.

### Frontend changes not reflected
- Use `npm run dev` during development.
- Use `npm run build` for production assets.

## Contributing
Please read `CONTRIBUTING.md` for standards, PR checklist, and validation commands.

## License
This project is licensed under the [MIT License](LICENSE).

## Contributors
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

## Acknowledgments
- [Laravel](https://laravel.com)
- [Stisla](https://getstisla.com)
- [Bootstrap](https://getbootstrap.com)
