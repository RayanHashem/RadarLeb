# Analytics Database Setup - Summary

## ✅ Completed Tasks

### 1. Database Configuration Updated

**File:** `config/database.php` (or `database.php` in root)

**Changes:**
- ✅ Added new connection `analytics_pg` for PostgreSQL analytics database
- ✅ Uses separate environment variables (ANALYTICS_DB_*)
- ✅ Existing `sqlite` connection **unchanged**
- ✅ Default connection remains `sqlite` (production unaffected)

**Connection Configuration:**
```php
'analytics_pg' => [
    'driver' => 'pgsql',
    'host' => env('ANALYTICS_DB_HOST'),
    'port' => env('ANALYTICS_DB_PORT', '5432'),
    'database' => env('ANALYTICS_DB_DATABASE'),
    'username' => env('ANALYTICS_DB_USERNAME'),
    'password' => env('ANALYTICS_DB_PASSWORD'),
    'charset' => env('ANALYTICS_DB_CHARSET', 'utf8'),
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => env('ANALYTICS_DB_SSLMODE', 'prefer'),
],
```

### 2. AWS RDS Setup Guide Created

**File:** `AWS_RDS_SETUP_GUIDE.md`

**Contents:**
- ✅ Step-by-step AWS Console instructions
- ✅ RDS instance creation guide
- ✅ Security group configuration (restricted access)
- ✅ VPC and networking setup
- ✅ Security best practices (never 0.0.0.0/0)
- ✅ Cost considerations
- ✅ Troubleshooting guide

### 3. Connection Test Command Created

**File:** `app/Console/Commands/TestAnalyticsConnection.php`

**Usage:**
```bash
php artisan analytics:test-connection
```

**Features:**
- ✅ Tests analytics PostgreSQL connection
- ✅ Verifies existing SQLite connection is unaffected
- ✅ Shows database version and current database name
- ✅ Provides helpful error messages and troubleshooting tips
- ✅ Logs errors for debugging

### 4. Environment Variables Template

Add to your `.env` file:

```env
# Existing database (DO NOT CHANGE)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Analytics PostgreSQL Connection (NEW)
ANALYTICS_DB_CONNECTION=pgsql
ANALYTICS_DB_HOST=your-rds-endpoint.xxxxx.us-east-1.rds.amazonaws.com
ANALYTICS_DB_PORT=5432
ANALYTICS_DB_DATABASE=radarleb_analytics
ANALYTICS_DB_USERNAME=your_username
ANALYTICS_DB_PASSWORD=your_secure_password
ANALYTICS_DB_SSLMODE=prefer
```

## Verification Steps

### Step 1: Create AWS RDS Instance

Follow the guide in `AWS_RDS_SETUP_GUIDE.md` to:
1. Create RDS PostgreSQL instance
2. Configure security group (restrict to your IP or app server SG)
3. Get connection details (endpoint, username, password)

### Step 2: Add Environment Variables

Add the `ANALYTICS_DB_*` variables to your `.env` file with your RDS credentials.

### Step 3: Clear Config Cache

```bash
php artisan config:clear
```

### Step 4: Test Connection

**Option A: Using the test command**
```bash
php artisan analytics:test-connection
```

**Option B: Using Tinker**
```bash
php artisan tinker
```
Then run:
```php
DB::connection('analytics_pg')->select('SELECT 1 as test');
```

**Expected Output:**
```
✅ Connection successful!
Database Information:
  PostgreSQL Version: PostgreSQL 15.x...
  Current Database: radarleb_analytics
✅ SQLite connection still working correctly
✅ All checks passed! Analytics database is ready.
```

### Step 5: Verify Existing Database Unaffected

```bash
php artisan tinker
```

```php
// Should still work
DB::connection('sqlite')->select('SELECT 1');

// Default connection should still be sqlite
config('database.default'); // Returns 'sqlite'
```

## Security Checklist

- ✅ Security group configured (NOT 0.0.0.0/0)
- ✅ Access restricted to specific IP or security group
- ✅ Strong password set
- ✅ SSL mode configured (prefer or require)
- ✅ Encryption enabled on RDS (recommended)

## Files Modified/Created

1. ✅ `config/database.php` - Added `analytics_pg` connection
2. ✅ `AWS_RDS_SETUP_GUIDE.md` - Complete setup instructions
3. ✅ `app/Console/Commands/TestAnalyticsConnection.php` - Test command
4. ✅ `ANALYTICS_DB_SETUP_SUMMARY.md` - This file

## Next Steps (DO NOT DO YET)

⚠️ **Wait for next task before:**
- Running migrations on analytics database
- Creating analytics tables
- Syncing data from SQLite to PostgreSQL

## Important Notes

1. **Existing Database Unaffected:**
   - Default connection remains `sqlite`
   - All existing code continues to use SQLite
   - Analytics connection is separate and optional

2. **No Breaking Changes:**
   - No existing code modified
   - No migrations run
   - Production database untouched

3. **Connection Usage:**
   - Use `DB::connection('analytics_pg')` for analytics queries
   - Use `DB::connection('sqlite')` or default for existing queries
   - Both can coexist without conflict

## Troubleshooting

If connection fails:

1. **Check Security Group:**
   - Verify inbound rule allows port 5432
   - Verify source IP/security group is correct
   - Your IP may have changed (check [whatismyip.com](https://whatismyip.com))

2. **Check Environment Variables:**
   - Run `php artisan config:clear`
   - Verify `.env` has all `ANALYTICS_DB_*` variables
   - Check for typos in endpoint, username, password

3. **Check RDS Status:**
   - Verify instance is "Available" in AWS Console
   - Check for any alerts or issues

4. **Check Network:**
   - If using public access, ensure it's enabled
   - If using private access, ensure you're on same VPC/VPN

See `AWS_RDS_SETUP_GUIDE.md` for detailed troubleshooting.

