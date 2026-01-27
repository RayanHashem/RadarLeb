# Local Laravel → AWS RDS PostgreSQL Connection Guide

## Step 1: Find RDS Connection Details in AWS Console

### Where to Find Each Value:

1. **Log in to AWS Console** → Go to **RDS** service

2. **Click on your database instance** (e.g., `radarleb-db`)

3. **Under "Connectivity & security" tab**, find:

   - **Endpoint:** `radarleb-db.col8o06a4whf.us-east-1.rds.amazonaws.com`
     - This is your `DB_HOST`
     - Copy the FULL endpoint (including `.rds.amazonaws.com`)
   
   - **Port:** `5432`
     - This is your `DB_PORT`
     - Usually 5432 for PostgreSQL
   
   - **Database name:** `radarleb-db`
     - This is your `DB_DATABASE`
     - Or check "Configuration" tab → "DB name"
   
   - **Username:** `radarleb_admin`
     - This is your `DB_USERNAME`
     - Or check "Configuration" tab → "Master username"
   
   - **Password:** 
     - This is the password you set when creating the instance
     - If you forgot it, you'll need to reset it in RDS console
     - ⚠️ **You provided:** `dCsuCX7A4wTyfnx`

### Quick Reference - Your Values:
```
DB_HOST=radarleb-db.col8o06a4whf.us-east-1.rds.amazonaws.com
DB_PORT=5432
DB_DATABASE=radarleb-db
DB_USERNAME=radarleb_admin
DB_PASSWORD=dCsuCX7A4wTyfnx
```

## Step 2: Update Local .env File

### 2.1 Backup Current .env (Optional but Recommended)

```powershell
# In PowerShell, from project root
Copy-Item .env .env.backup.sqlite
```

### 2.2 Update .env File

Open `.env` in your editor and **change these lines:**

**Find:**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

**Replace with:**
```env
DB_CONNECTION=pgsql
DB_HOST=radarleb-db.col8o06a4whf.us-east-1.rds.amazonaws.com
DB_PORT=5432
DB_DATABASE=radarleb-db
DB_USERNAME=radarleb_admin
DB_PASSWORD=dCsuCX7A4wTyfnx
```

**Important:** Remove or comment out the old SQLite line:
```env
# DB_DATABASE=database/database.sqlite  # Commented out - using RDS now
```

### 2.3 Complete Database Section Should Look Like:

```env
# Database Configuration (PostgreSQL - AWS RDS)
DB_CONNECTION=pgsql
DB_HOST=radarleb-db.col8o06a4whf.us-east-1.rds.amazonaws.com
DB_PORT=5432
DB_DATABASE=radarleb-db
DB_USERNAME=radarleb_admin
DB_PASSWORD=dCsuCX7A4wTyfnx
```

## Step 3: Verify Laravel Config Supports PostgreSQL

The `config/database.php` file already has PostgreSQL support. Verify it exists:

**File:** `config/database.php` (or `database.php` in root)

**Should contain:**
```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => env('DB_CHARSET', 'utf8'),
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => 'prefer',
],
```

✅ **This is already configured correctly** - no changes needed.

## Step 4: Check PHP PostgreSQL Extension (Windows)

### 4.1 Check if pdo_pgsql is Enabled

```powershell
php -m | findstr pdo_pgsql
```

**Expected output if enabled:**
```
pdo_pgsql
```

**If you see nothing**, the extension is not enabled.

### 4.2 Find Your php.ini File Location

```powershell
php --ini
```

**Expected output:**
```
Configuration File (php.ini) Path: C:\php
Loaded Configuration File:         C:\php\php.ini
```

**Note the "Loaded Configuration File" path** - this is the file you need to edit.

### 4.3 Enable pdo_pgsql Extension

1. **Open the php.ini file** (from Step 4.2) in a text editor **as Administrator**

2. **Search for** `extension=pdo_pgsql` (use Ctrl+F)

3. **If you find it with a semicolon (`;`) in front:**
   ```ini
   ;extension=pdo_pgsql
   ```
   **Remove the semicolon:**
   ```ini
   extension=pdo_pgsql
   ```

4. **If you don't find it at all**, add this line in the extensions section:
   ```ini
   extension=pdo_pgsql
   ```

5. **Also check for** `extension=pgsql` (without pdo_):
   ```ini
   extension=pgsql
   ```
   Make sure it's also enabled (remove semicolon if present).

6. **Save the file**

7. **Restart your web server** (if using Apache/Nginx) or just restart `php artisan serve`

### 4.4 Verify Extension is Loaded

```powershell
php -m | findstr pdo_pgsql
php -m | findstr pgsql
```

**Both should show output:**
```
pdo_pgsql
pgsql
```

## Step 5: Clear Cache and Test Connection

### 5.1 Clear All Caches

```powershell
php artisan optimize:clear
php artisan config:clear
```

### 5.2 Test Connection via Tinker

```powershell
php artisan tinker
```

**Then run:**
```php
DB::select('SELECT 1 as ok');
```

**Expected output:**
```
=> [
     {#1234
       +"ok": 1,
     },
   ]
```

**If you see this**, connection is working! ✅

**Exit tinker:**
```php
exit
```

### 5.3 Alternative: Test Connection Command

```powershell
php artisan analytics:test-connection
```

**Note:** This command tests the `analytics_pg` connection. To test default connection, use tinker method above.

## Step 6: Verify Connection Details

In tinker, you can also check:

```php
// Check default connection
config('database.default'); // Should return 'pgsql'

// Check connection config
config('database.connections.pgsql.host');
config('database.connections.pgsql.database');
config('database.connections.pgsql.username');
```

## Troubleshooting

### Issue 1: "SQLSTATE[HY000] [2002] Connection timed out"

**Cause:** Security group not allowing your IP

**Fix:**
1. Go to AWS Console → RDS → Your database
2. Click on security group (under "Connectivity & security")
3. Click "Edit inbound rules"
4. Add rule:
   - Type: PostgreSQL
   - Port: 5432
   - Source: Your current IP (find at [whatismyip.com](https://whatismyip.com))
   - Format: `YOUR_IP/32` (e.g., `203.0.113.1/32`)
5. Save rules
6. Wait 30 seconds, try again

### Issue 2: "SQLSTATE[08006] [7] could not connect to server"

**Cause:** Public access disabled or wrong endpoint

**Fix:**
1. Go to AWS Console → RDS → Your database
2. Check "Connectivity & security" → "Publicly accessible"
   - Should be **"Yes"** for local testing
   - If "No", click "Modify" → Enable public access → Apply immediately
3. Verify endpoint is correct (should end with `.rds.amazonaws.com`)

### Issue 3: "SQLSTATE[28P01] password authentication failed"

**Cause:** Wrong username or password

**Fix:**
1. Double-check username and password in `.env`
2. Check for extra spaces (trim them)
3. Verify in AWS Console:
   - RDS → Your database → "Configuration" tab
   - Check "Master username"
4. If password is wrong, reset it:
   - RDS → Your database → "Modify"
   - Change master password
   - Update `.env` with new password

### Issue 4: "Call to undefined function pg_connect()" or "Class 'PDO' not found"

**Cause:** pdo_pgsql extension not enabled

**Fix:**
1. Follow Step 4 above to enable extension
2. Verify with `php -m | findstr pdo_pgsql`
3. Restart `php artisan serve` if running

### Issue 5: "SQLSTATE[3D000] database does not exist"

**Cause:** Wrong database name

**Fix:**
1. Check database name in AWS Console:
   - RDS → Your database → "Configuration" tab
   - Look for "DB name"
2. Update `.env` with correct database name
3. Run `php artisan config:clear`

### Issue 6: "SQLSTATE[HY000] [2002] No connection could be made"

**Cause:** Wrong endpoint or port

**Fix:**
1. Verify endpoint in AWS Console:
   - RDS → Your database → "Connectivity & security"
   - Copy the FULL endpoint
2. Verify port is 5432 (default for PostgreSQL)
3. Check `.env` has no extra spaces

## Quick Checklist

- [ ] Found all values in AWS RDS Console
- [ ] Updated `.env` with PostgreSQL credentials
- [ ] Verified `config/database.php` has pgsql connection
- [ ] Checked PHP has pdo_pgsql extension (`php -m | findstr pdo_pgsql`)
- [ ] Enabled pdo_pgsql in php.ini if missing
- [ ] Cleared caches (`php artisan optimize:clear`)
- [ ] Tested connection in tinker (`DB::select('SELECT 1 as ok')`)
- [ ] Connection successful ✅

## Exact Commands to Copy/Paste

```powershell
# 1. Check PHP extension
php -m | findstr pdo_pgsql

# 2. Find php.ini location
php --ini

# 3. Clear caches
php artisan optimize:clear
php artisan config:clear

# 4. Test connection
php artisan tinker
# Then in tinker:
DB::select('SELECT 1 as ok');
exit
```

## Important Notes

- ✅ This change is **LOCAL ONLY** (your `.env` file)
- ✅ Production/other environments still use their own `.env` files
- ✅ No code changes needed - Laravel already supports PostgreSQL
- ⚠️ **DO NOT run migrations yet** unless explicitly told to
- ⚠️ Make sure security group allows your IP before testing

## Reverting to SQLite (If Needed)

If you need to switch back to SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Then:
```powershell
php artisan config:clear
```

