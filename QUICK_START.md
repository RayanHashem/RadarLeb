# Quick Start Guide

## 🚀 Fastest Path to Running the App

### Prerequisites Check
```powershell
php --version      # Need 8.2+
composer --version # Need installed
node --version     # Need 18+
npm --version      # Need installed
```

### 5-Minute Setup

```powershell
# 1. Install dependencies
composer install
npm install

# 2. Create .env file (see template below)
# Copy the template and create .env

# 3. Generate app key
php artisan key:generate

# 4. Setup database (SQLite - easiest)
New-Item -ItemType File -Path "database\database.sqlite" -Force
php artisan migrate

# 5. Create storage link
php artisan storage:link

# 6. Start everything
composer run dev
```

### .env File Template

Create a `.env` file in the project root with this content:

```env
APP_NAME="Radarleb"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_STORE=database
FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

**Important**: After creating `.env`, run `php artisan key:generate` to populate `APP_KEY`.

---

## 📍 Access Points

- **Application**: http://localhost:8000
- **Vite Dev Server**: http://localhost:5173 (auto-proxied)

---

## 🛠️ Common Commands

| Task | Command |
|------|---------|
| Start all services | `composer run dev` |
| Laravel server only | `php artisan serve` |
| Vite dev server only | `npm run dev` |
| Run migrations | `php artisan migrate` |
| Clear cache | `php artisan config:clear` |
| Queue worker | `php artisan queue:work` |

---

## ⚠️ Common Issues

**"No application encryption key"**
→ Run: `php artisan key:generate`

**"Database connection failed"**
→ Check `.env` DB settings or create SQLite file

**"Vite manifest not found"**
→ Run: `npm run dev` (in separate terminal or use `composer run dev`)

**"Class not found"**
→ Run: `composer dump-autoload`

---

## 📚 Full Documentation

See `SETUP_GUIDE.md` for complete setup instructions, troubleshooting, and detailed explanations.


