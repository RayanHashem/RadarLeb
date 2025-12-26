# Local Development Setup Guide

## 📋 Project Analysis

### Technology Stack Identified

#### **Backend**
- **Framework**: Laravel 12.0 (PHP 8.2+ required)
- **Package Manager**: Composer
- **Architecture**: Monolithic with Inertia.js integration

#### **Frontend**
- **Framework**: Vue 3 with TypeScript
- **Build Tool**: Vite 6.2.0
- **Package Manager**: npm
- **UI Library**: Reka UI components
- **Styling**: Tailwind CSS 4.1.1
- **Routing**: Inertia.js (SPA-like experience, no separate API)

#### **Communication Pattern**
- **Primary**: Inertia.js - Server-side routes return Inertia responses that render Vue components
- **Secondary**: Some API endpoints in `auth.php` (e.g., `/games`, `/scan/{game}`, `/me`)
- **SSR Support**: Available via `npm run build:ssr` and `php artisan inertia:start-ssr`

### Project Structure

**⚠️ IMPORTANT NOTE**: The project structure appears unusual - files are in the root directory rather than typical Laravel structure. This may indicate:
- A flattened export/backup
- A non-standard Laravel setup
- Files may need to be organized into proper Laravel directories

**Expected Laravel Structure** (if files need reorganization):
```
project-root/
├── app/              (Controllers, Models, Middleware)
├── bootstrap/        (App bootstrap files)
├── config/           (Configuration files)
├── database/         (Migrations, Seeders)
├── public/           (index.php, assets)
├── resources/        (Vue components, CSS, JS)
│   ├── js/
│   │   ├── app.ts
│   │   ├── ssr.ts
│   │   └── pages/
│   └── css/
├── routes/            (web.php, auth.php)
├── storage/           (Logs, cache, uploads)
├── vendor/            (Composer dependencies)
└── node_modules/      (npm dependencies)
```

---

## 🔧 Prerequisites

### Required Software

1. **PHP 8.2 or higher** ✅ (You have PHP 8.4.3)
   - Required extensions:
     - `pdo`, `pdo_mysql` (or `pdo_sqlite` for SQLite)
     - `mbstring`, `xml`, `openssl`, `tokenizer`, `json`, `curl`
     - `fileinfo`, `zip`

2. **Composer** (PHP dependency manager)
   - Download from: https://getcomposer.org/download/
   - Verify: `composer --version`

3. **Node.js 18+ and npm** ✅ (You have Node.js v20.14.0)
   - Verify: `node --version` and `npm --version`

4. **Database** (Choose one):
   - **SQLite** (easiest for local dev) - No setup needed, file-based
   - **MySQL 8.0+** - For production-like environment
   - **PostgreSQL** - Alternative option

5. **Optional but Recommended**:
   - **Redis** - For caching/queues (can use database driver instead)
   - **Git** - Version control

### Verify Prerequisites

Run these commands to check your setup:

```powershell
php --version          # Should show PHP 8.2+
composer --version     # Should show Composer version
node --version         # Should show Node.js 18+
npm --version          # Should show npm version
```

---

## 🚀 Step-by-Step Setup Instructions

### Step 1: Install PHP Dependencies

```powershell
# Navigate to project directory
cd "C:\Users\rayan\Desktop\Radarleb coding"

# Install Composer dependencies
composer install
```

**Expected output**: Creates `vendor/` directory with Laravel and all PHP packages.

**If errors occur**:
- Missing PHP extensions: Install via your PHP package manager or enable in `php.ini`
- Memory limit: Increase `memory_limit` in `php.ini` to at least 512M

---

### Step 2: Install Node.js Dependencies

```powershell
# Install npm packages
npm install
```

**Expected output**: Creates `node_modules/` directory with Vue, Vite, and all frontend packages.

**If errors occur**:
- Clear npm cache: `npm cache clean --force`
- Delete `package-lock.json` and `node_modules/` if corrupted, then reinstall

---

### Step 3: Create Environment File

**⚠️ CRITICAL**: The `.env` file is missing and required for the application to run.

Create a `.env` file in the project root. You can start with this template:

```powershell
# Copy from .env.example if it exists, or create new
# If .env.example doesn't exist, create .env manually
```

**Create `.env` file with these minimum required variables**:

```env
APP_NAME="Radarleb"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

# Database Configuration (SQLite - Easiest for local)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# OR MySQL Configuration (if using MySQL)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=radarleb
# DB_USERNAME=root
# DB_PASSWORD=

# Queue Configuration
QUEUE_CONNECTION=database

# Session Driver
SESSION_DRIVER=database

# Cache Driver
CACHE_STORE=database

# Filesystem (use local instead of S3 for development)
FILESYSTEM_DISK=local

# Mail Configuration (for development)
MAIL_MAILER=log
MAIL_HOST=localhost
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Frontend Vite Configuration
VITE_APP_NAME="${APP_NAME}"
```

**Important**: After creating `.env`, generate the application key:

```powershell
php artisan key:generate
```

This will populate `APP_KEY` in your `.env` file.

---

### Step 4: Database Setup

#### Option A: SQLite (Recommended for Quick Start)

```powershell
# Create database file
New-Item -ItemType File -Path "database\database.sqlite" -Force

# Run migrations
php artisan migrate
```

#### Option B: MySQL

1. **Create database**:
   ```sql
   CREATE DATABASE radarleb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Update `.env`** with MySQL credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=radarleb
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

3. **Run migrations**:
   ```powershell
   php artisan migrate
   ```

#### Option C: Using Laravel Sail (Docker)

If you have Docker installed:

```powershell
# Start Docker containers (includes MySQL)
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate
```

---

### Step 5: Create Storage Link

Laravel needs a symbolic link for public file access:

```powershell
php artisan storage:link
```

**Windows Note**: If symlink fails, you may need to run PowerShell as Administrator, or manually copy files.

---

### Step 6: Seed Database (Optional)

If seeders exist:

```powershell
php artisan db:seed
# Or specific seeder
php artisan db:seed --class=GameSeeder
```

---

### Step 7: Build Frontend Assets

#### For Development (with hot reload):

```powershell
npm run dev
```

This starts Vite dev server on port 5173 (default).

#### For Production Build:

```powershell
npm run build
```

---

### Step 8: Start the Application

#### Method 1: Using Composer Dev Script (Recommended)

The project has a convenient dev script that starts everything:

```powershell
composer run dev
```

This command (defined in `composer.json` line 54-56) runs:
- `php artisan serve` (Laravel server on port 8000)
- `php artisan queue:listen` (Queue worker)
- `php artisan pail` (Log viewer)
- `npm run dev` (Vite dev server)

#### Method 2: Manual Start (Separate Terminals)

**Terminal 1 - Laravel Server**:
```powershell
php artisan serve
```

**Terminal 2 - Vite Dev Server**:
```powershell
npm run dev
```

**Terminal 3 - Queue Worker** (if using queues):
```powershell
php artisan queue:work
```

#### Method 3: Laravel Sail (Docker)

```powershell
./vendor/bin/sail up
```

Access at: `http://localhost`

---

### Step 9: Access the Application

Open your browser and navigate to:
- **Local**: `http://localhost:8000`
- **With Sail**: `http://localhost`

---

## 🔍 Troubleshooting Common Errors

### Error 1: "No application encryption key has been specified"

**Solution**:
```powershell
php artisan key:generate
```

---

### Error 2: "SQLSTATE[HY000] [2002] No connection could be made"

**Causes**:
- Database server not running
- Wrong database credentials in `.env`
- Database doesn't exist

**Solutions**:
- Check MySQL is running: `mysql --version`
- Verify `.env` database credentials
- Create database if missing
- Or switch to SQLite (easier for local dev)

---

### Error 3: "Vite manifest not found"

**Causes**:
- Frontend assets not built
- Vite dev server not running

**Solutions**:
```powershell
# Option 1: Start Vite dev server
npm run dev

# Option 2: Build assets
npm run build
```

---

### Error 4: "Class 'App\\...' not found"

**Causes**:
- Composer autoloader not updated
- Missing dependencies

**Solutions**:
```powershell
composer dump-autoload
composer install
```

---

### Error 5: "Permission denied" (Storage/Logs)

**Windows**: Usually not an issue, but if it occurs:
```powershell
# Ensure storage directories exist and are writable
New-Item -ItemType Directory -Path "storage\framework\cache" -Force
New-Item -ItemType Directory -Path "storage\framework\sessions" -Force
New-Item -ItemType Directory -Path "storage\framework\views" -Force
New-Item -ItemType Directory -Path "storage\logs" -Force
```

---

### Error 6: "Service Worker registration failed"

This is a warning, not critical. The app will work without it. To fix:
- Ensure `public/sw.js` exists
- Check browser console for specific errors

---

## 📝 Environment Variables Reference

### Required Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_KEY` | Encryption key | Generated by `php artisan key:generate` |
| `APP_URL` | Application URL | `http://localhost:8000` |
| `DB_CONNECTION` | Database driver | `sqlite` or `mysql` |
| `DB_DATABASE` | Database name/path | `database/database.sqlite` or `radarleb` |

### Optional but Recommended

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_ENV` | Environment | `local` |
| `APP_DEBUG` | Debug mode | `true` (local) |
| `QUEUE_CONNECTION` | Queue driver | `database` |
| `FILESYSTEM_DISK` | Storage disk | `local` |
| `VITE_APP_NAME` | Frontend app name | `Laravel` |

### AWS-Specific (For Production)

If the app uses AWS in production, these can be left empty for local:

- `AWS_ACCESS_KEY_ID`
- `AWS_SECRET_ACCESS_KEY`
- `AWS_DEFAULT_REGION`
- `AWS_BUCKET`
- `AWS_URL`

**Local Alternative**: Set `FILESYSTEM_DISK=local` in `.env`

---

## 🎯 Quick Start Checklist

- [ ] PHP 8.2+ installed
- [ ] Composer installed
- [ ] Node.js 18+ installed
- [ ] Run `composer install`
- [ ] Run `npm install`
- [ ] Create `.env` file
- [ ] Run `php artisan key:generate`
- [ ] Set up database (SQLite or MySQL)
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan storage:link`
- [ ] Start dev servers: `composer run dev`
- [ ] Access `http://localhost:8000`

---

## 🔄 Development Workflow

### Daily Development

1. **Start services**:
   ```powershell
   composer run dev
   ```

2. **Make changes** to:
   - PHP files (Laravel): Auto-reloads
   - Vue/TypeScript files: Vite hot-reloads
   - CSS files: Vite hot-reloads

3. **Database changes**:
   ```powershell
   # Create migration
   php artisan make:migration create_example_table
   
   # Run migration
   php artisan migrate
   
   # Rollback
   php artisan migrate:rollback
   ```

### Building for Production

```powershell
# Build frontend
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ❓ Questions to Ask Original Developer

If you encounter issues not covered here, ask:

1. **Environment**:
   - "What environment variables are required that aren't in the standard Laravel setup?"
   - "Are there any AWS services (S3, SQS, etc.) that need local alternatives?"

2. **Database**:
   - "What database is used in production? (MySQL version, PostgreSQL, etc.)"
   - "Do I need seed data to test the application?"

3. **Dependencies**:
   - "Are there any external services/APIs the app depends on?"
   - "Do I need API keys or credentials for third-party services?"

4. **Structure**:
   - "Why are files in the root directory instead of standard Laravel structure?"
   - "Is this a backup/export, or the actual project structure?"

5. **Configuration**:
   - "Are there any special server configurations needed?"
   - "What PHP extensions are required beyond standard Laravel?"

---

## 📚 Additional Resources

- **Laravel Documentation**: https://laravel.com/docs/12.x
- **Inertia.js Documentation**: https://inertiajs.com
- **Vue 3 Documentation**: https://vuejs.org
- **Vite Documentation**: https://vitejs.dev

---

## 🆘 Still Having Issues?

1. Check `storage/logs/laravel.log` for detailed error messages
2. Enable debug mode: `APP_DEBUG=true` in `.env`
3. Clear caches:
   ```powershell
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```
4. Verify all prerequisites are installed correctly
5. Check that ports 8000 (Laravel) and 5173 (Vite) are not in use

---

**Last Updated**: Based on analysis of project files
**Project**: Radarleb
**Laravel Version**: 12.0
**PHP Version Required**: 8.2+


