# Quick Checklist: Connect Local Laravel to AWS RDS

## ✅ Step 1: Find RDS Values in AWS Console

1. AWS Console → **RDS** → Click your database (`radarleb-db`)
2. **"Connectivity & security" tab:**
   - **Endpoint:** `radarleb-db.col8o06a4whf.us-east-1.rds.amazonaws.com` → `DB_HOST`
   - **Port:** `5432` → `DB_PORT`
3. **"Configuration" tab:**
   - **DB name:** `radarleb-db` → `DB_DATABASE`
   - **Master username:** `radarleb_admin` → `DB_USERNAME`
   - **Password:** The one you set (you provided: `dCsuCX7A4wTyfnx`) → `DB_PASSWORD`

## ✅ Step 2: Update .env File

**Open `.env` and change:**

```env
DB_CONNECTION=pgsql
DB_HOST=radarleb-db.col8o06a4whf.us-east-1.rds.amazonaws.com
DB_PORT=5432
DB_DATABASE=radarleb-db
DB_USERNAME=radarleb_admin
DB_PASSWORD=dCsuCX7A4wTyfnx
```

**Remove or comment out:**
```env
# DB_DATABASE=database/database.sqlite
```

## ✅ Step 3: Check PHP PostgreSQL Extension

```powershell
php -m | findstr pdo_pgsql
```

**If nothing shows**, enable it:

1. Find php.ini:
```powershell
php --ini
```

2. Open the "Loaded Configuration File" path in notepad (as Admin)

3. Search for `extension=pdo_pgsql` and remove semicolon:
```ini
extension=pdo_pgsql
extension=pgsql
```

4. Save and restart `php artisan serve`

## ✅ Step 4: Clear Cache & Test

```powershell
php artisan optimize:clear
php artisan config:clear
php artisan tinker
```

**In tinker:**
```php
DB::select('SELECT 1 as ok');
exit
```

**Expected:** `[{"ok": 1}]` ✅

## 🆘 Troubleshooting

### Connection Timeout?
- AWS Console → RDS → Security Group → Edit inbound rules
- Add: PostgreSQL, Port 5432, Source: `YOUR_IP/32` (get from [whatismyip.com](https://whatismyip.com))

### Wrong Password?
- Check `.env` for extra spaces
- AWS Console → RDS → Modify → Reset master password

### No pdo_pgsql?
- Follow Step 3 above
- Verify: `php -m | findstr pdo_pgsql`

### Wrong Endpoint?
- AWS Console → RDS → "Connectivity & security" → Copy full endpoint

## 📋 All Commands (Copy/Paste)

```powershell
# Check extension
php -m | findstr pdo_pgsql

# Find php.ini
php --ini

# Clear cache
php artisan optimize:clear
php artisan config:clear

# Test connection
php artisan tinker
# Then: DB::select('SELECT 1 as ok');
```

