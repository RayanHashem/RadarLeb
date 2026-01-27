# Filament Admin Panel - Local Setup Guide

## Complete Step-by-Step Instructions to Run Admin Panel Locally (No 404s)

### Prerequisites
- Laravel 11
- Filament v3
- SQLite database (local)
- Both public RadarLeb app + Filament admin in same project

---

## 1️⃣ Correct Local Startup Commands (In Order)

### Terminal 1: Laravel Development Server

**Required Command:**
```bash
php artisan serve
```

**Expected Output:**
```
INFO  Server running on [http://127.0.0.1:8000]
```

**Note:** Keep this terminal open. The server runs until you press `Ctrl+C`.

### Terminal 2: Frontend Assets (Optional - Only if using Vite/compiled assets)

**Optional Command:**
```bash
npm run dev
```

**When Required:**
- Only if you modified Filament views/CSS/JS
- Only if you see missing assets (CSS/JS not loading)
- For production builds: `npm run build`

**Note:** For basic Filament admin usage, this is usually **NOT required** since Filament assets are served via CDN or compiled separately.

### Summary

| Command | Required? | Purpose |
|--------|-----------|---------|
| `php artisan serve` | ✅ **YES** | Starts Laravel server |
| `npm run dev` | ❌ Optional | Only for custom frontend assets |

---

## 2️⃣ Exact URLs to Test (Copy-Paste Ready)

### Admin Login Page
```
http://127.0.0.1:8000/admin/login
```

### Admin Dashboard (After Login)
```
http://127.0.0.1:8000/admin
```

### Public App (For Reference)
```
http://127.0.0.1:8000/
```

### Route List (Verify Routes Exist)
```bash
php artisan route:list --path=admin
```

---

## 3️⃣ How to Confirm Admin Routes Exist

### Step 1: Run Route List Command

**Exact Command:**
```bash
php artisan route:list --path=admin
```

**Alternative (See All Routes):**
```bash
php artisan route:list | grep admin
```

### Step 2: Expected Output Should Include

You should see routes like:

```
GET|HEAD  admin/login ................... filament.admin.auth.login
GET|HEAD  admin ......................... filament.admin.pages.dashboard
GET|HEAD  admin/users ................... filament.admin.resources.users.index
GET|HEAD  admin/prizes .................. filament.admin.pages.prizes-analytics
GET|HEAD  admin/winners/all ............. filament.admin.pages.all-winners
... (more admin routes)
```

**Key Indicators:**
- ✅ Routes start with `admin/`
- ✅ Route names contain `filament.admin`
- ✅ Login route exists: `filament.admin.auth.login`
- ✅ Dashboard route exists: `filament.admin.pages.dashboard`

### Step 3: If Routes Are Missing

If you see **NO** `admin/` routes, the panel is not registered. See Section 4️⃣.

---

## 4️⃣ Common Causes of 404s in THIS Project

### Cause 1: providers.php Location (Laravel 11)

**Problem:** Laravel 11 expects `bootstrap/providers.php`, not root `providers.php`.

**How to Check:**
```bash
# Check if file exists in correct location
ls -la bootstrap/providers.php
# OR on Windows:
dir bootstrap\providers.php
```

**What Should Be Inside:**
```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,  // ← Must be here
];
```

**How to Fix:**
1. If file doesn't exist: Create `bootstrap/providers.php`
2. If file is in wrong location: Move from root to `bootstrap/`
3. Ensure `AdminPanelProvider::class` is in the array

**Verify:**
```bash
php artisan config:clear
php artisan route:clear
php artisan serve
```

---

### Cause 2: Cached Routes/Config

**Problem:** Laravel is serving old cached routes/config that don't include Filament.

**How to Check:**
```bash
# Check if cache files exist
ls -la bootstrap/cache/config.php
ls -la bootstrap/cache/routes-v7.php
```

**How to Fix:**
```bash
# Clear ALL caches (run in order)
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

**Then Restart:**
```bash
php artisan serve
```

---

### Cause 3: Wrong Port

**Problem:** Server running on different port than expected.

**How to Check:**
Look at terminal output when running `php artisan serve`:
```
INFO  Server running on [http://127.0.0.1:8000]  ← Check this port
```

**How to Fix:**
- If port 8000 is taken, Laravel will use 8001, 8002, etc.
- Use the **exact port** shown in terminal output
- Or specify port explicitly: `php artisan serve --port=8000`

**Correct URLs:**
- If port 8000: `http://127.0.0.1:8000/admin/login`
- If port 8001: `http://127.0.0.1:8001/admin/login`

---

### Cause 4: Wrong APP_URL

**Problem:** `.env` has wrong `APP_URL`, causing route generation issues.

**How to Check:**
```bash
# Check .env file
cat .env | grep APP_URL
# OR on Windows:
findstr APP_URL .env
```

**What It Should Be (Local):**
```env
APP_URL=http://127.0.0.1:8000
# OR
APP_URL=http://localhost:8000
```

**How to Fix:**
1. Edit `.env` file
2. Set `APP_URL=http://127.0.0.1:8000` (match your actual port)
3. Run: `php artisan config:clear`
4. Restart: `php artisan serve`

---

### Cause 5: Wrong Database File

**Problem:** SQLite database file not found or wrong path.

**How to Check:**
```bash
# Check database config
php artisan tinker
>>> config('database.connections.sqlite.database')
```

**Expected Output:**
```
"database/database.sqlite"
# OR absolute path like
"C:\Users\rayan\Desktop\Radarleb coding\database\database.sqlite"
```

**How to Fix:**
1. Ensure `.env` has:
   ```env
   DB_CONNECTION=sqlite
   # DB_DATABASE should be empty or point to correct file
   ```
2. Ensure database file exists:
   ```bash
   ls -la database/database.sqlite
   # OR on Windows:
   dir database\database.sqlite
   ```
3. If missing, create it:
   ```bash
   touch database/database.sqlite
   # OR on Windows:
   type nul > database\database.sqlite
   ```
4. Run migrations:
   ```bash
   php artisan migrate
   ```

---

### Cause 6: Filament Panel Registration Timing

**Problem:** Panel not registered due to provider loading order.

**How to Check:**
```bash
php artisan tinker
>>> Filament\Facades\Filament::getPanels()
```

**Expected Output:**
```php
[
  "admin" => Filament\Panel { ... }
]
```

**If Empty:** Panel is not registered. Check `bootstrap/providers.php`.

**How to Fix:**
1. Verify `AdminPanelProvider::class` is in `bootstrap/providers.php`
2. Clear caches: `php artisan optimize:clear`
3. Restart server: `php artisan serve`

---

## 5️⃣ One "Safe Checklist" (Follow Every Time)

### Pre-Startup Checklist

**Step 1: Verify Database**
```bash
# Check SQLite file exists
ls database/database.sqlite
# If missing: touch database/database.sqlite && php artisan migrate
```

**Step 2: Verify Providers**
```bash
# Check providers.php exists and contains AdminPanelProvider
cat bootstrap/providers.php | grep AdminPanelProvider
# Should show: App\Providers\Filament\AdminPanelProvider::class
```

**Step 3: Clear All Caches**
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**Step 4: Start Server**
```bash
php artisan serve
```
**Note the port shown** (usually 8000)

**Step 5: Verify Routes**
```bash
# In a NEW terminal (keep server running)
php artisan route:list --path=admin
```
**Should show admin routes** (see Section 3️⃣)

**Step 6: Test Login Page**
```
Visit: http://127.0.0.1:8000/admin/login
```
**Should show Filament login form** (not 404)

---

### If It 404s → Troubleshooting Steps

**A. Check Server is Running**
- Look at terminal: Should show "Server running on..."
- If not: Run `php artisan serve` again

**B. Check Correct Port**
- Use **exact port** from terminal output
- If terminal shows port 8001, use `http://127.0.0.1:8001/admin/login`

**C. Verify Routes Exist**
```bash
php artisan route:list --path=admin
```
- If **no routes shown**: Panel not registered → Check `bootstrap/providers.php`
- If **routes shown**: Continue to step D

**D. Clear Caches Again**
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
# Restart server
php artisan serve
```

**E. Check Panel Registration**
```bash
php artisan tinker
>>> Filament\Facades\Filament::getPanels()
```
- Should show `["admin" => ...]`
- If empty: Fix `bootstrap/providers.php` (see Cause 1)

**F. Check APP_URL**
```bash
cat .env | grep APP_URL
```
- Should match your server port: `APP_URL=http://127.0.0.1:8000`
- If wrong: Fix `.env` and run `php artisan config:clear`

**G. Hard Refresh Browser**
- Press `Ctrl+Shift+R` (Windows/Linux)` or `Cmd+Shift+R` (Mac)
- Or clear browser cache

**H. Check Database**
```bash
php artisan tinker
>>> config('database.connections.sqlite.database')
```
- Should show valid path to SQLite file
- If missing: Create file and run migrations

---

## Quick Reference: Common Commands

### Startup (Every Time)
```bash
php artisan optimize:clear
php artisan serve
```

### Verify Routes
```bash
php artisan route:list --path=admin
```

### Clear Caches (If 404)
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
```

### Check Panel Registration
```bash
php artisan tinker
>>> Filament\Facades\Filament::getPanels()
```

---

## Expected File Structure

```
project-root/
├── app/
│   └── Providers/
│       └── Filament/
│           └── AdminPanelProvider.php  ← Must exist
├── bootstrap/
│   └── providers.php  ← Must contain AdminPanelProvider
├── database/
│   └── database.sqlite  ← Must exist
├── .env  ← Must have correct APP_URL
└── routes/
    └── web.php
```

---

## Final Verification

After following all steps, you should be able to:

1. ✅ Run `php artisan serve` without errors
2. ✅ See admin routes in `php artisan route:list --path=admin`
3. ✅ Visit `http://127.0.0.1:8000/admin/login` and see login form
4. ✅ Login and access dashboard at `http://127.0.0.1:8000/admin`

---

**If all steps above pass, /admin/login should never return 404 locally.**



