# SafeLab Kids - Laravel Backend Integration Guide

## 1. Setup Fresh Laravel Project
Run this in your terminal to create a new Laravel project:
```bash
composer create-project laravel/laravel safelab-kids
cd safelab-kids
```

## 2. Install Authentication Boilerplate
We recommend Laravel Breeze for a quick, clean auth scaffold (Login/Register pages):
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

## 3. Merge Core Files
Copy the folders from this ZIP archive (`app`, `database`, `routes`, `resources`) directly into your newly created `safelab-kids` directory. Overwrite files if prompted.

## 4. Run Migrations
Configure your `.env` file with your database credentials (MySQL/PostgreSQL), then run:
```bash
php artisan migrate
```

## 5. API Testing
The application is now structured to serve web pages via Blade, and handle interactive simulation data via RESTful APIs. You can hit the API endpoints at `/api/experiments` using Postman, Insomnia, or Axios from your frontend.
