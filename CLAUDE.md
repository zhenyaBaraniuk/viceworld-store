# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application with Filament 4 admin panel. It uses PHP 8.3, SQLite database, and Vite for frontend asset compilation with Tailwind CSS 4.

## Development Commands

### Initial Setup
```bash
composer setup
```
This runs: composer install, copies .env.example to .env (if needed), generates app key, runs migrations, installs npm packages, and builds assets.

### Running Development Environment
```bash
composer dev
```
This starts multiple services concurrently:
- Laravel development server (php artisan serve)
- Queue worker (php artisan queue:listen --tries=1)
- Log viewer (php artisan pail)
- Vite dev server for hot module reloading (npm run dev)

All services run together and will stop if any one fails.

Alternatively, run services individually:
```bash
php artisan serve         # Start Laravel dev server
npm run dev              # Start Vite dev server
php artisan queue:listen # Start queue worker
php artisan pail         # View logs in real-time
```

### Testing
```bash
composer test
# Or run directly:
php artisan test

# Run specific test suite:
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run specific test file:
php artisan test tests/Feature/ExampleTest.php

# Run with coverage (requires Xdebug or PCOV):
php artisan test --coverage
```

### Code Quality
```bash
# Format code with Laravel Pint:
./vendor/bin/pint

# Format specific files:
./vendor/bin/pint app/Models/User.php
```

### Database
```bash
# Run migrations:
php artisan migrate

# Rollback migrations:
php artisan migrate:rollback

# Fresh migration (drops all tables):
php artisan migrate:fresh

# Seed database:
php artisan db:seed
```

### Artisan Commands
```bash
# Clear caches:
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate resources:
php artisan make:model ModelName -m     # Create model with migration
php artisan make:controller ControllerName
php artisan make:migration create_table_name

# Tinker (REPL):
php artisan tinker
```

### Frontend Assets
```bash
npm run build    # Build production assets
npm run dev      # Start Vite dev server with HMR
```

## Architecture

### Filament Admin Panel

The application uses Filament 4 for the admin panel, configured at `/admin` path.

**Admin Panel Configuration**: `app/Providers/Filament/AdminPanelProvider.php`
- Panel ID: `admin`
- Path: `/admin`
- Authentication: Login page enabled
- Primary color: Amber

**Filament Directory Structure** (auto-discovered):
- `app/Filament/Resources/` - CRUD resources (models with forms, tables, actions)
- `app/Filament/Pages/` - Custom admin pages
- `app/Filament/Widgets/` - Dashboard widgets

When creating Filament resources, use:
```bash
php artisan make:filament-resource ModelName --generate
```

### Laravel Structure

**Standard Laravel Directory Layout**:
- `app/Http/Controllers/` - HTTP controllers
- `app/Models/` - Eloquent models
- `app/Providers/` - Service providers
- `routes/web.php` - Web routes
- `routes/console.php` - Console commands
- `database/migrations/` - Database migrations
- `database/factories/` - Model factories for testing
- `database/seeders/` - Database seeders
- `resources/views/` - Blade templates
- `resources/css/` - CSS files (compiled by Vite)
- `resources/js/` - JavaScript files (compiled by Vite)
- `tests/Feature/` - Feature tests
- `tests/Unit/` - Unit tests

### Frontend Setup

Uses Vite with Laravel plugin for asset compilation:
- Tailwind CSS 4 (via @tailwindcss/vite plugin)
- Hot Module Replacement in development
- Entry points: `resources/css/app.css` and `resources/js/app.js`
- Framework views in `storage/framework/views/` are ignored by Vite watcher

### Database

Uses SQLite by default (`database/database.sqlite`).
- In testing environment, uses in-memory SQLite (`:memory:`)
- Connection configured via `DB_CONNECTION` and `DB_DATABASE` env variables

### Testing Configuration

PHPUnit is configured with two test suites:
- **Unit**: `tests/Unit/` - Isolated unit tests
- **Feature**: `tests/Feature/` - Integration tests

Test environment uses:
- In-memory SQLite database
- Array cache driver
- Sync queue connection
- Array mail driver (no emails sent)
- Fast bcrypt rounds (4) for performance