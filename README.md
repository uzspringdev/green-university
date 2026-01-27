# Green University Admission Website

Complete admission website for Green University Uzbekistan built with Yii2 PHP Framework and PostgreSQL.

## 🎉 Implementation Status: 90% Complete

## Features

- ✅ **Multi-language Support** - Uzbek, English, Russian with dynamic switching
- ✅ **Dynamic Content Management** - Pages, News, Announcements
- ✅ **Admin Panel** - CRUD for News, Applications (other modules ready for Gii generation)
- ✅ **Professional Modern Design** - Responsive, gradient-based UI with animations
- ✅ **Admission Applications** - Online application system with status management
- ✅ **News System** - Categories, featured news, view counter, image upload
- ✅ **Image Upload** - For news articles and sliders
- ✅ **Translation System** - Database-backed translations for all content

## Requirements

- PHP >= 7.4
- PostgreSQL >= 12 **with PDO driver enabled**
- Composer
- Web server (Apache/Nginx or PHP built-in server)

## Installation

### 1. Enable PostgreSQL PDO Driver

**Windows (php.ini):**
```ini
extension=pdo_pgsql
extension=pgsql
```

**Linux:**
```bash
sudo apt-get install php-pgsql
```

Restart PHP/web server after enabling.

### 2. Database Setup

Create PostgreSQL database:
```bash
psql -U postgres
CREATE DATABASE green_university;
\q
```

Configure database connection in `common/config/main-local.php`:
```php
'db' => [
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=green_university',
    'username' => 'postgres',
    'password' => 'your_password',
],
```

### 3. Run Migrations

```bash
php yii migrate --interactive=0
```

This will create all necessary tables.

### 4. Insert Base Data

```bash
# Add languages
psql -U postgres -d green_university -c "
INSERT INTO language (code, name, is_default, status, sort_order) VALUES 
('uz', 'O''zbekcha', true, 1, 0),
('en', 'English', false, 1, 1),
('ru', 'Русский', false, 1, 2);
"
```

### 5. Start Development Server

```bash
# Frontend (user-facing site)
php -S localhost:8080 -t frontend/web

# Backend (admin panel) - in another terminal
php -S localhost:8081 -t backend/web
```

## Access

- **Frontend (Public Website)**: http://localhost:8080
- **Admin Panel**: http://localhost:8081
- **Gii Code Generator**: http://localhost:8081/gii (for generating additional CRUDs)

## Multi-Language System

Switching Languages:
- Uzbek: `?lang=uz` (default)
- English: `?lang=en`
- Russian: `?lang=ru`

Language preference is stored in cookies and session.

## Generating Additional Backend CRUDs

For remaining features, use Gii generator:

1. Access http://localhost:8081/gii
2. Select "CRUD Generator"
3. Generate for each model: Page, Announcement, Menu, Slider, etc.

See `backend_crud_plan.md` in brain folder for detailed instructions.

## Documentation

- `final_summary.md` - Complete implementation summary
- `backend_crud_plan.md` - Guide for generating CRUDs
- `walkthrough.md` - Technical details

## License

Proprietary - Green University Uzbekistan
