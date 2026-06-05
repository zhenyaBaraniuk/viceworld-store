# V!ceWorld

V!ceWorld is a B2C e-commerce platform for streetwear — clothing for men, women, and kids.

This is a pet project built with Laravel and React, driven by a desire to grow as a full-stack developer and to create a real-world example that demonstrates practical skills.

Many clothing stores feel heavy and overcomplicated. This project demonstrates that an e-commerce site in this space can be clean, lightweight, and genuinely pleasant to use — making the process of buying clothes simple and enjoyable.

---

## Requirements

- PHP >= 8.3
- Laravel >= 12.0
- Node.js >= 22.0.0
- MySQL >= 8.0

---

## Installation

**1. Clone the repository**

```bash
git clone <repo-url>
```

**2. Copy environment file**

```bash
cp .env.example .env
```

**3. Generate application key**

```bash
php artisan key:generate
```

**4. Install dependencies**

```bash
composer install
```

**5. Run migrations**

```bash
php artisan migrate
```

**6. Seed the database**

```bash
php artisan db:seed
```

**7. Create admin panel user**

```bash
php artisan make:filament-user
```
