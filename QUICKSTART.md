# Quick Start (5-10 Minutes)

## 1) Install
```bash
git clone https://github.com/vickymaulana/laravel12-stisla.git
cd laravel12-stisla
composer install
npm install
```

## 2) Configure app
```bash
cp .env.example .env
php artisan key:generate
```

Edit database config in `.env`, then run:
```bash
php artisan migrate
```

Optional:
```bash
php artisan db:seed
php artisan storage:link
```

## 3) Run app
```bash
npm run dev
php artisan serve
```

Open `http://localhost:8000`.

## 4) First login flow
1. Register at `/register`
2. Login at `/login`
3. Go to `/quick-tour`

## 5) Superadmin quick setup
Create/update one user role to `superadmin` (via DB or tinker):
```bash
php artisan tinker
```
```php
App\Models\User::where('email', 'your@email.com')->update(['role' => 'superadmin']);
```

## 6) Password reset mode
Default mode in `.env`:
```env
PASSWORD_RESET_METHOD=token
```
Optional OTP hardening:
```env
PASSWORD_RESET_METHOD=otp
PASSWORD_RESET_OTP_EXPIRE=10
PASSWORD_RESET_OTP_MAX_ATTEMPTS=5
```

## 7) Sanity checks
```bash
php artisan route:list --except-vendor
php artisan test
```

## Common Problems
- Assets missing: run `npm run dev` or `npm run build`
- Download/upload issue: run `php artisan storage:link`
- OTP not sent: verify `MAIL_*` config
- Route list crash: check custom controller syntax/imports
