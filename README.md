# Backend - Laravel API

This is the backend API for the Task Manager App built with Laravel 10.

## 🔧 Requirements

- PHP >= 8.1
- Composer
- Laravel CLI
- MySQL (or any supported database)

## 🚀 Setup Instructions

```bash
cd backend

# Install dependencies
composer install

# Rename environment file
mv .env.example .env

# Edit `.env` to set your DB and other environment variables

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Start development server
php artisan serve

# Run the tast cases
php artisan test


