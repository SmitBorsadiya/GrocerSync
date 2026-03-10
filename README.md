# 🛒 GrocerSync

**GrocerSync** is a grocery inventory management application built with Laravel and Livewire. It enables store owners to efficiently manage products, vendors, and stock levels through a reactive, real-time interface — with built-in support for cross-platform mobile deployment via NativePHP.

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Installation & Setup](#-installation--setup)
- [Environment Variables](#-environment-variables)
- [Running the Project](#-running-the-project)
- [Database Setup & Migrations](#-database-setup--migrations)
- [Mobile (NativePHP)](#-mobile-nativephp)

---

## 🔍 Overview

Managing grocery inventory across multiple vendors can become complex and error-prone. **GrocerSync** addresses this by providing a centralized platform where users can:

- Track products with pricing, quantities, and low-stock thresholds.
- Manage vendor information and link products to their suppliers.
- Quickly search and filter inventory for day-to-day operations.

The application uses a modern, reactive UI powered by Livewire and Flux components, and can be packaged as a native mobile app (Android/iOS) using NativePHP.

---

## ✨ Features

| Category             | Details                                                                 |
|----------------------|-------------------------------------------------------------------------|
| **Product Management** | Full CRUD — create, edit, soft-delete products with validation        |
| **Vendor Management**  | Full CRUD — manage supplier names, phone numbers, and addresses       |
| **Search & Filter**    | Real-time product search by name and filter by vendor                 |
| **Pagination**         | Paginated product and vendor listings (10 items per page)             |
| **Low-Stock Tracking** | Configurable threshold quantity per product                           |
| **Soft Deletes**       | Products and vendors are soft-deleted, preserving historical data     |
| **Authentication**     | User registration, login, email verification, password reset          |
| **Two-Factor Auth**    | Optional TOTP-based 2FA via Laravel Fortify                           |
| **User Settings**      | Profile editing, password change, appearance (dark/light mode)        |
| **Mobile Ready**       | Android & iOS deployment via NativePHP Mobile                         |

---

## 🛠 Tech Stack

| Layer        | Technology                                         |
|--------------|-----------------------------------------------------|
| **Backend**  | [PHP 8.2+](https://php.net), [Laravel 12](https://laravel.com) |
| **Frontend** | [Livewire 4](https://livewire.laravel.com), [Flux UI 2](https://flux.livewire.laravel.com), [Tailwind CSS 4](https://tailwindcss.com) |
| **Auth**     | [Laravel Fortify](https://laravel.com/docs/fortify) (with 2FA support) |
| **Database** | SQLite (default), MySQL/PostgreSQL supported        |
| **Build**    | [Vite 7](https://vite.dev), [laravel-vite-plugin](https://github.com/laravel/vite-plugin) |
| **Mobile**   | [NativePHP Mobile 3](https://nativephp.com)         |
| **Testing**  | [PHPUnit 11](https://phpunit.de)                    |
| **Linting**  | [Laravel Pint](https://laravel.com/docs/pint)       |

---

## 📁 Project Structure

```
GrocerSync/
├── app/
│   ├── Actions/                # Application action classes
│   ├── Concerns/               # Shared traits (password & profile validation rules)
│   ├── Http/Controllers/       # Base controller
│   ├── Livewire/
│   │   ├── Actions/            # Livewire action components (Logout)
│   │   ├── Product/            # ProductManager — product CRUD component
│   │   └── Vendor/             # VendorManager — vendor CRUD component
│   ├── Models/
│   │   ├── Product.php         # Product model (belongs to Vendor, soft deletes)
│   │   ├── User.php            # User model (Fortify 2FA, notifications)
│   │   └── Vendor.php          # Vendor model (has many Products, soft deletes)
│   └── Providers/              # AppServiceProvider, FortifyServiceProvider
│
├── config/                     # Laravel & NativePHP configuration files
├── database/
│   └── migrations/             # Database schema migrations
├── nativephp/                  # NativePHP mobile build artifacts
├── resources/
│   ├── css/                    # Application stylesheets
│   ├── js/                     # JavaScript entry point
│   └── views/
│       ├── components/         # Reusable Blade components
│       ├── layouts/            # App and auth layout templates
│       ├── livewire/           # Livewire component Blade views
│       ├── pages/
│       │   ├── auth/           # Login, register, password reset, 2FA views
│       │   └── settings/       # Profile, password, appearance, 2FA settings
│       ├── dashboard.blade.php # Dashboard page
│       └── welcome.blade.php   # Landing page
│
├── routes/
│   ├── web.php                 # Main web routes (dashboard, products, vendors)
│   ├── settings.php            # User settings routes
│   └── console.php             # Console/Artisan commands
│
├── tests/                      # PHPUnit feature & unit tests
├── composer.json               # PHP dependencies
├── package.json                # Node.js dependencies
├── vite.config.js              # Vite build configuration
└── .env.example                # Environment variable template
```

---

## 📌 Prerequisites

- **PHP** ≥ 8.2
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x & **npm**
- **SQLite** (included by default) or MySQL/PostgreSQL
- **Android SDK & ADB** (only if building for Android via NativePHP)

---

## 🚀 Installation & Setup

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-username/GrocerSync.git
   cd GrocerSync
   ```

2. **Run the setup script** (installs PHP & Node deps, generates key, runs migrations, builds assets)

   ```bash
   composer setup
   ```

   **— OR do it manually —**

   ```bash
   # Install PHP dependencies
   composer install

   # Copy environment file
   cp .env.example .env

   # Generate application key
   php artisan key:generate

   # Install Node dependencies
   npm install

   # Build frontend assets
   npm run build

   # Create SQLite database and run migrations
   php artisan migrate
   ```

---

## 🔐 Environment Variables

Copy `.env.example` to `.env` and configure as needed:

| Variable                       | Description                            | Default               |
|--------------------------------|----------------------------------------|-----------------------|
| `APP_NAME`                     | Application display name               | `Laravel`             |
| `APP_ENV`                      | Environment (`local`, `production`)    | `local`               |
| `APP_DEBUG`                    | Enable debug mode                      | `true`                |
| `APP_URL`                      | Base URL of the application            | `http://localhost`    |
| `DB_CONNECTION`                | Database driver                        | `sqlite`              |
| `DB_DATABASE`                  | Database path (SQLite) or name         | `database/database.sqlite` |
| `SESSION_DRIVER`               | Session storage driver                 | `database`            |
| `QUEUE_CONNECTION`             | Queue driver                           | `database`            |
| `CACHE_STORE`                  | Cache driver                           | `database`            |
| `NATIVEPHP_APP_ID`             | Unique app ID for NativePHP builds     | *(empty)*             |
| `NATIVEPHP_APP_VERSION`        | App version string                     | `1.0.0`               |
| `NATIVEPHP_APP_VERSION_CODE`   | Numeric version code (Android)         | `1`                   |

> **Note:** For NativePHP mobile builds, additional variables are available — see [`config/nativephp.php`](config/nativephp.php) for the full list.

---

## ▶️ Running the Project

### Development (recommended)

Start all services (web server, queue worker, log viewer, Vite) simultaneously:

```bash
composer dev
```

This runs:
- `php artisan serve` — Laravel dev server
- `php artisan queue:listen` — Queue worker
- `php artisan pail` — Real-time log viewer  
- `npm run dev` — Vite dev server with HMR

The application will be available at **http://localhost:8000**.

### Individual Services

```bash
# Laravel dev server
php artisan serve

# Vite dev server (in a separate terminal)
npm run dev
```

### Production Build

```bash
npm run build
```

---

## 🗄 Database Setup & Migrations

The project uses **SQLite** by default. The database file is created automatically during setup.

### Run Migrations

```bash
php artisan migrate
```

### Database Schema

| Table        | Key Columns                                                                           |
|--------------|---------------------------------------------------------------------------------------|
| `users`      | `id`, `name`, `email`, `password`, `two_factor_secret`, `two_factor_recovery_codes`  |
| `vendors`    | `id`, `name`, `phone`, `address`, `is_active`, `deleted_at`                          |
| `products`   | `id`, `vendor_id` (FK), `name`, `description`, `price`, `unit`, `quantity`, `threshold_qty`, `is_active`, `deleted_at` |
| `sessions`   | User session storage                                                                  |
| `cache`      | Application cache entries                                                             |
| `jobs`       | Queue job storage                                                                     |

### Reset Database

```bash
php artisan migrate:fresh
```

---

## 📱 Mobile (NativePHP)

GrocerSync can be built as a native mobile app using [NativePHP Mobile](https://nativephp.com).

### Setup

1. Install the NativePHP dependencies:
   ```bash
   php artisan native:install
   ```

2. Configure your `.env` with:
   ```env
   NATIVEPHP_APP_ID=com.yourcompany.grocersync
   NATIVEPHP_APP_VERSION=1.0.0
   NATIVEPHP_APP_VERSION_CODE=1
   ```

3. For Android, ensure the Android SDK and ADB are in your PATH.

### Run on Device / Emulator

```bash
php artisan native:run
```

### Build for Production

```bash
php artisan native:build
```

See [`config/nativephp.php`](config/nativephp.php) for detailed build configuration options including orientation, permissions, and App Store Connect settings.

