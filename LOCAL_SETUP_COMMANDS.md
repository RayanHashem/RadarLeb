# Local Setup - Exact Commands to Run

## ⚠️ Current Status
- ✅ `.env` file created
- ✅ `bootstrap/app.php` created  
- ⚠️ Composer dependencies may be incomplete (Windows file locking issues)
- ⚠️ npm dependencies not installed
- ⚠️ Database not created
- ⚠️ Application key not generated

## 🔧 Step-by-Step Commands

### Step 1: Complete Composer Installation

**If you see file locking errors**, try one of these:

```powershell
# Option 1: Retry with verbose output
php composer.phar install -vvv

# Option 2: If antivirus is blocking, temporarily disable it, then:
php composer.phar install

# Option 3: Install without scripts first, then run scripts
php composer.phar install --no-scripts
php composer.phar run-script post-install-cmd
```

**Verify installation**:
```powershell
Test-Path vendor\laravel\framework
# Should return: True
```

### Step 2: Complete npm Installation

```powershell
# Install Node.js dependencies
npm install

# If you get file locking errors, wait a few minutes and retry
# Windows Search Indexer or antivirus may be scanning files
```

**Verify installation**:
```powershell
Test-Path node_modules\vite
# Should return: True
```

### Step 3: Generate Application Key

```powershell
php artisan key:generate
```

This will populate `APP_KEY` in your `.env` file.

### Step 4: Create SQLite Database

```powershell
# Ensure database directory exists
New-Item -ItemType Directory -Path database -Force

# Create SQLite database file
New-Item -ItemType File -Path database\database.sqlite -Force
```

### Step 5: Run Database Migrations

```powershell
php artisan migrate
```

**If migrations fail**, check:
- Database file exists: `Test-Path database\database.sqlite`
- Database is writable
- `.env` has correct `DB_CONNECTION=sqlite` and `DB_DATABASE=database/database.sqlite`

### Step 6: Create Storage Link

```powershell
php artisan storage:link
```

**Windows Note**: If symlink fails, you may need to:
- Run PowerShell as Administrator, OR
- Manually create the link, OR
- Skip this step if not using file uploads

### Step 7: Start the Application

**Option 1: All-in-one (Recommended)**
```powershell
php composer.phar run dev
```

**Option 2: Manual (Separate Terminals)**

Terminal 1 - Laravel Server:
```powershell
php artisan serve
```

Terminal 2 - Vite Dev Server:
```powershell
npm run dev
```

Terminal 3 - Queue Worker (if using queues):
```powershell
php artisan queue:work
```

### Step 8: Access the Application

Open your browser:
- **Application**: http://localhost:8000
- **Vite Dev Server**: http://localhost:5173 (auto-proxied by Laravel)

---

## 🐛 Troubleshooting

### Error: "Class Illuminate\Foundation\Application not found"

**Cause**: Composer dependencies not fully installed

**Fix**:
```powershell
php composer.phar install
php composer.phar dump-autoload
```

### Error: "Vite manifest not found"

**Cause**: Frontend assets not built or Vite not running

**Fix**:
```powershell
# Start Vite dev server
npm run dev

# OR build assets
npm run build
```

### Error: "Database connection failed"

**Cause**: SQLite file doesn't exist or wrong path

**Fix**:
```powershell
# Check .env has:
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

# Create database file
New-Item -ItemType File -Path database\database.sqlite -Force

# Verify path is correct (relative to project root)
```

### Error: "No application encryption key"

**Cause**: APP_KEY not set in .env

**Fix**:
```powershell
php artisan key:generate
```

### Error: File locking during installation

**Cause**: Windows Search Indexer or antivirus scanning files

**Fix**:
1. Wait 2-3 minutes for indexing to complete
2. Temporarily disable antivirus real-time scanning
3. Add project folder to antivirus exclusions
4. Retry installation

### Error: "bootstrap/app.php not found"

**Cause**: Missing bootstrap directory (should be fixed now)

**Fix**: Already created - verify with:
```powershell
Test-Path bootstrap\app.php
```

---

## ✅ Verification Checklist

Run these to verify setup:

```powershell
# 1. Check .env exists
Test-Path .env

# 2. Check APP_KEY is set
Select-String -Path .env -Pattern "APP_KEY=" | Select-Object -First 1

# 3. Check vendor directory
Test-Path vendor\laravel\framework

# 4. Check node_modules
Test-Path node_modules\vite

# 5. Check database
Test-Path database\database.sqlite

# 6. Check bootstrap
Test-Path bootstrap\app.php

# 7. Test artisan
php artisan --version
```

---

## 📋 Complete Command Sequence

Here's the complete sequence in order:

```powershell
# 1. Install Composer (if not installed globally)
# Already done - using php composer.phar

# 2. Install PHP dependencies
php composer.phar install

# 3. Install Node.js dependencies  
npm install

# 4. Generate app key
php artisan key:generate

# 5. Create database
New-Item -ItemType Directory -Path database -Force
New-Item -ItemType File -Path database\database.sqlite -Force

# 6. Run migrations
php artisan migrate

# 7. Create storage link
php artisan storage:link

# 8. Start application
php composer.phar run dev
```

---

## 🎯 Expected Final State

After running all commands successfully:

- ✅ `.env` file with `APP_KEY` populated
- ✅ `vendor/` directory with Laravel and all dependencies
- ✅ `node_modules/` directory with Vue, Vite, and all frontend packages
- ✅ `database/database.sqlite` file created
- ✅ Database tables created (from migrations)
- ✅ Application accessible at http://localhost:8000
- ✅ Vite dev server running on port 5173

---

## ❓ Questions for Original Developer

Only ask these if setup still fails after following all steps:

1. **"Is the project structure correct? Files appear to be in root instead of standard Laravel directories (app/, bootstrap/, config/, etc.)"**

2. **"Are there any custom setup steps or initialization scripts that need to run?"**

3. **"Do I need any seed data to test the application? (php artisan db:seed)"**

4. **"Are there any environment variables beyond standard Laravel that are required?"**

5. **"What external services/APIs does the app depend on that need local alternatives or mocks?"**


