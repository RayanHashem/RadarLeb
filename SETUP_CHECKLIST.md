# 🚀 Local Setup Checklist - Windows

## Current Status
- ✅ `.env` file exists with SQLite and local drivers
- ✅ Project structure complete (bootstrap, routes, storage, public)
- ⚠️ SQLite database missing (will create)
- ❌ Composer dependencies missing
- ❌ npm dependencies missing

---

## Step-by-Step Commands

### STEP 1: Complete Composer Installation

**Command:**
```powershell
php composer.phar install
```

**Expected Time:** 2-5 minutes

**Success Looks Like:**
- No errors at the end
- Last line shows "Generating optimized autoload files"
- `vendor\laravel\framework` directory exists

**Verify Success:**
```powershell
Test-Path vendor\laravel\framework
# Should return: True
```

**If It Fails with File Locking:**

**Error Pattern:** `Could not delete .../vendor/composer/tmp-*.zip: This can be due to an antivirus...`

**Fixes (try in order):**

1. **Check if project is in OneDrive/Dropbox:**
   ```powershell
   $pwd.Path
   # If path contains "OneDrive" or "Dropbox", move project outside
   ```

2. **Add to Windows Defender Exclusions:**
   - Open Windows Security → Virus & threat protection
   - Manage settings → Exclusions → Add or remove exclusions
   - Add folder: `C:\Users\rayan\Desktop\Radarleb coding`

3. **Wait and Retry:**
   ```powershell
   # Wait 2-3 minutes for Windows Search Indexer to finish
   Start-Sleep -Seconds 120
   php composer.phar install
   ```

4. **Temporarily Disable Real-time Protection (last resort):**
   - Windows Security → Virus & threat protection → Manage settings
   - Turn off "Real-time protection" temporarily
   - Run: `php composer.phar install`
   - Turn it back on after installation

**Retry Command:**
```powershell
php composer.phar install
```

---

### STEP 2: Install Frontend Dependencies

**Command:**
```powershell
npm install
```

**Expected Time:** 1-3 minutes

**Success Looks Like:**
- No errors at the end
- Shows "added X packages"
- `node_modules\vite` directory exists

**Verify Success:**
```powershell
Test-Path node_modules\vite
# Should return: True
```

**If It Fails:**

**Error Pattern:** `EPERM: operation not permitted, rmdir`

**Fix:**
- Wait 1-2 minutes
- Retry: `npm install`

**Retry Command:**
```powershell
npm install
```

---

### STEP 3: Generate Application Key

**Command:**
```powershell
php artisan key:generate
```

**Expected Time:** < 5 seconds

**Success Looks Like:**
- Shows "Application key set successfully"
- `.env` file now has `APP_KEY=base64:...` (not empty)

**Verify Success:**
```powershell
Select-String -Path .env -Pattern "^APP_KEY=base64:" | Select-Object -First 1
# Should show a line with APP_KEY=base64:...
```

**If It Fails:**

**Error:** "Class Illuminate\Foundation\Application not found"

**Fix:**
```powershell
php composer.phar dump-autoload
php artisan key:generate
```

**Retry Command:**
```powershell
php artisan key:generate
```

---

### STEP 4: Create SQLite Database

**Command:**
```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
```

**Expected Time:** < 1 second

**Success Looks Like:**
- No errors
- File created

**Verify Success:**
```powershell
Test-Path database\database.sqlite
# Should return: True
```

**If It Fails:**

**Error:** Permission denied

**Fix:** Run PowerShell as Administrator, then retry

**Retry Command:**
```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
```

---

### STEP 5: Run Database Migrations

**Command:**
```powershell
php artisan migrate
```

**Expected Time:** 5-15 seconds

**Success Looks Like:**
- Shows "Migrating: YYYY_MM_DD_create_xxx_table"
- Ends with "Migration completed successfully" or similar
- No errors

**Verify Success:**
```powershell
php artisan migrate:status
# Should show all migrations as "Ran"
```

**If It Fails:**

**Error:** "SQLSTATE[HY000] [14] unable to open database file"

**Fix:**
- Verify database file exists: `Test-Path database\database.sqlite`
- Check file permissions
- Ensure database directory exists: `New-Item -ItemType Directory -Path database -Force`

**Retry Command:**
```powershell
php artisan migrate
```

---

### STEP 6: Create Storage Link

**Command:**
```powershell
php artisan storage:link
```

**Expected Time:** < 1 second

**Success Looks Like:**
- Shows "The [public/storage] link has been connected"
- No errors

**Verify Success:**
```powershell
Test-Path public\storage
# Should return: True (or Test-Path -PathType Link)
```

**If It Fails:**

**Error:** "symlink(): Cannot create symlink, error code(1314)"

**Fix:** Run PowerShell as Administrator

**Retry Command (as Admin):**
```powershell
php artisan storage:link
```

**Alternative (if symlink still fails):**
- Skip this step for now (only needed for file uploads)
- App will still run without it

---

### STEP 7: Start the Application

**Preferred Method (All-in-One):**

**Command:**
```powershell
php composer.phar run dev
```

**Expected Time:** Starts immediately, runs continuously

**Success Looks Like:**
- Shows multiple colored outputs:
  - `[server]` - Laravel server starting
  - `[vite]` - Vite dev server starting
  - `[queue]` - Queue worker starting
  - `[logs]` - Log viewer starting
- No fatal errors
- Shows "Laravel development server started: http://127.0.0.1:8000"

**Access URL:** http://localhost:8000

**If It Fails:**

**Error:** "Class not found" or "Vite manifest not found"

**Fix:** See troubleshooting section below

**Alternative Method (Manual - Separate Terminals):**

**Terminal 1 - Laravel Server:**
```powershell
php artisan serve
```
- Should show: "Laravel development server started: http://127.0.0.1:8000"

**Terminal 2 - Vite Dev Server:**
```powershell
npm run dev
```
- Should show: "VITE v6.x.x  ready in xxx ms" and "➜  Local:   http://localhost:5173/"

**Access URL:** http://localhost:8000 (Laravel serves the app, Vite proxies assets)

---

## 🐛 Troubleshooting

### If App Shows 500 Error

**Check Logs:**
```powershell
Get-Content storage\logs\laravel.log -Tail 120
```

**Common Causes & Fixes:**

1. **Missing APP_KEY:**
   ```powershell
   php artisan key:generate
   ```

2. **Database Error:**
   ```powershell
   # Verify database exists
   Test-Path database\database.sqlite
   # Re-run migrations
   php artisan migrate
   ```

3. **Class Not Found:**
   ```powershell
   php composer.phar dump-autoload
   ```

4. **Vite Manifest Not Found:**
   ```powershell
   # Make sure Vite is running
   npm run dev
   # OR build assets
   npm run build
   ```

### If "Class Illuminate\Foundation\Application not found"

**Fix:**
```powershell
php composer.phar dump-autoload
php artisan --version
```

**If still fails:**
```powershell
# Reinstall composer dependencies
php composer.phar install
```

### If "Vite manifest not found"

**Fix:**
```powershell
# Start Vite dev server (in separate terminal)
npm run dev

# OR build production assets
npm run build
```

**Then refresh browser**

---

## ✅ Final Verification

After all steps, verify:

```powershell
# 1. Dependencies
Test-Path vendor\laravel\framework  # Should be True
Test-Path node_modules\vite         # Should be True

# 2. Configuration
Select-String -Path .env -Pattern "^APP_KEY=base64:"  # Should show key

# 3. Database
Test-Path database\database.sqlite  # Should be True

# 4. Artisan works
php artisan --version  # Should show Laravel version

# 5. App accessible
# Open browser: http://localhost:8000
```

---

## 🎯 Success Criteria

✅ Application accessible at **http://localhost:8000**  
✅ No errors in browser console  
✅ Laravel server running on port 8000  
✅ Vite dev server running on port 5173 (if using dev mode)  
✅ Database tables created  
✅ Hot reload working (frontend changes auto-refresh)

---

## 📝 Quick Reference

**Complete Command Sequence:**
```powershell
# 1. Install PHP dependencies
php composer.phar install

# 2. Install Node.js dependencies
npm install

# 3. Generate app key
php artisan key:generate

# 4. Create database
New-Item -ItemType File -Path database\database.sqlite -Force

# 5. Run migrations
php artisan migrate

# 6. Create storage link
php artisan storage:link

# 7. Start application
php composer.phar run dev
```

**Then open:** http://localhost:8000


