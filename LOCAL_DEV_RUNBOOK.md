# Local Development Runbook - Filament Admin Panel

**Quick reference guide to run the admin panel locally without 404 errors.**

---

## 🚀 Fresh Clone Setup (Run Once)

Execute these commands in order from the project root:

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment file (if .env doesn't exist)
cp .env.example .env

# 3. Generate application key (if APP_KEY is empty in .env)
php artisan key:generate

# 4. Ensure SQLite database file exists
# Windows:
if not exist database\database.sqlite type nul > database\database.sqlite
# Linux/Mac:
touch database/database.sqlite

# 5. Run migrations (if database is empty)
php artisan migrate

# 6. Publish Filament assets (required for admin panel)
php artisan filament:assets

# 7. Clear all caches
php artisan optimize:clear

# 8. Start development server
php artisan serve
```

**Expected Output:**
```
INFO  Server running on [http://127.0.0.1:8000]
```

**Note:** Keep the server running. Press `Ctrl+C` to stop.

---

## ✅ Test URLs

After starting the server, test these URLs:

- **Admin Login:** `http://127.0.0.1:8000/admin/login`
- **Admin Dashboard:** `http://127.0.0.1:8000/admin` (after login)
- **Public App:** `http://127.0.0.1:8000/`

---

## 🔍 DB Sanity Check

Run these commands in `php artisan tinker` to verify database connectivity and data:

### Step 1: Verify SQLite Path

```php
// Get the exact SQLite database path
config('database.connections.sqlite.database')

// Alternative method
\Illuminate\Support\Facades\DB::connection()->getDatabaseName()
```

**Expected Output:**
```
"C:\Users\rayan\Desktop\Radarleb coding\database\database.sqlite"
// OR on Linux/Mac:
"/path/to/project/database/database.sqlite"
```

### Step 2: Confirm File Exists

```php
// Check if file exists
file_exists(config('database.connections.sqlite.database'))
```

**Expected Output:** `true`

### Step 3: Print Table Counts

```php
// Count records in each table
echo "Users: " . \App\Models\User::count() . "\n";
echo "Games: " . \App\Models\Game::count() . "\n";
echo "Scans: " . \App\Models\Scan::count() . "\n";
echo "GameUserStats: " . \App\Models\GameUserStat::count() . "\n";
echo "Winners: " . \App\Models\Winner::count() . "\n";
```

### Step 4: Count Records with amount_spent > 0

```php
// Count game_user_stats with amount_spent > 0
\App\Models\GameUserStat::where('amount_spent', '>', 0)->count()

// Count per game
foreach ([1, 2, 3, 4, 5] as $gameId) {
    $count = \App\Models\GameUserStat::where('game_id', $gameId)
        ->where('amount_spent', '>', 0)
        ->count();
    echo "Game {$gameId}: {$count} users with amount_spent > 0\n";
}
```

---

## 🔧 404 Troubleshooting

If `/admin` or `/admin/login` returns 404, follow these steps:

### Step 1: Verify Provider Registration

**Check if `bootstrap/providers.php` exists:**
```bash
# Windows:
dir bootstrap\providers.php
# Linux/Mac:
ls -la bootstrap/providers.php
```

**Verify it contains `AdminPanelProvider`:**
```bash
# Windows:
findstr AdminPanelProvider bootstrap\providers.php
# Linux/Mac:
grep AdminPanelProvider bootstrap/providers.php
```

**Expected Output:**
```
App\Providers\Filament\AdminPanelProvider::class,
```

**If missing or wrong location:**
- File must be at: `bootstrap/providers.php` (NOT root `providers.php`)
- Must contain: `App\Providers\Filament\AdminPanelProvider::class`

### Step 2: Verify Admin Routes Exist

```bash
php artisan route:list --path=admin
```

**Expected Output Should Include:**
```
GET|HEAD  admin/login ................... filament.admin.auth.login
GET|HEAD  admin ......................... filament.admin.pages.dashboard
GET|HEAD  admin/users ................... filament.admin.resources.users.index
GET|HEAD  admin/prizes .................. filament.admin.pages.prizes-analytics
... (more admin routes)
```

**If NO admin routes appear:**
- Panel is not registered → Fix `bootstrap/providers.php`
- See Step 1 above

### Step 3: Clear All Caches

```bash
# Clear all caches (run in order)
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Step 4: Restart Server

```bash
# Stop current server (Ctrl+C), then:
php artisan serve
```

### Step 5: Verify Panel Registration (Advanced)

```bash
php artisan tinker
```

```php
// Check if admin panel is registered
\Filament\Facades\Filament::getPanels()
```

**Expected Output:**
```php
[
  "admin" => Filament\Panel { ... }
]
```

**If empty:** Panel not registered → Fix `bootstrap/providers.php`

### Step 6: Check APP_URL

```bash
# Windows:
findstr APP_URL .env
# Linux/Mac:
grep APP_URL .env
```

**Should match your server port:**
```env
APP_URL=http://127.0.0.1:8000
# OR
APP_URL=http://localhost:8000
```

**If wrong:** Update `.env` and run `php artisan config:clear`

---

## 📋 Quick Checklist

Before reporting issues, verify:

- [ ] `bootstrap/providers.php` exists and contains `AdminPanelProvider`
- [ ] `database/database.sqlite` file exists
- [ ] `php artisan route:list --path=admin` shows admin routes
- [ ] `php artisan optimize:clear` has been run
- [ ] Server is running on correct port (check terminal output)
- [ ] `.env` has correct `APP_URL` matching server port
- [ ] `php artisan filament:assets` has been run

---

## 🆘 Still Getting 404?

1. **Check server is actually running:**
   - Look at terminal: Should show "Server running on..."
   - If not: Run `php artisan serve` again

2. **Check correct port:**
   - Use **exact port** from terminal output
   - If terminal shows port 8001, use `http://127.0.0.1:8001/admin/login`

3. **Hard refresh browser:**
   - Press `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
   - Or clear browser cache

4. **Verify database file:**
   ```bash
   php artisan tinker
   ```
   ```php
   file_exists(config('database.connections.sqlite.database'))
   ```
   - Should return `true`
   - If `false`: Create file and run migrations (see Fresh Clone Setup)

---

**If all steps pass and you still get 404, check the full troubleshooting guide in `LOCAL_ADMIN_SETUP_GUIDE.md`**

