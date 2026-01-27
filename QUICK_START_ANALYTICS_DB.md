# Quick Start: Analytics Database Setup

## ✅ What's Been Done

1. ✅ Added `analytics_pg` connection to `config/database.php`
2. ✅ Created AWS RDS setup guide (`AWS_RDS_SETUP_GUIDE.md`)
3. ✅ Created test command (`php artisan analytics:test-connection`)
4. ✅ Existing SQLite database **completely unaffected**

## 🚀 Next Steps (In Order)

### Step 1: Create AWS RDS Instance

Follow the detailed guide: **`AWS_RDS_SETUP_GUIDE.md`**

**Quick summary:**
1. AWS Console → RDS → Create database
2. Choose PostgreSQL
3. Set identifier: `radarleb-analytics-dev`
4. Set database name: `radarleb_analytics`
5. Configure security group (restrict to your IP, NOT 0.0.0.0/0)
6. Save endpoint, username, password

### Step 2: Add to .env

Add these lines to your `.env` file:

```env
# Analytics PostgreSQL Connection
ANALYTICS_DB_CONNECTION=pgsql
ANALYTICS_DB_HOST=your-rds-endpoint.xxxxx.us-east-1.rds.amazonaws.com
ANALYTICS_DB_PORT=5432
ANALYTICS_DB_DATABASE=radarleb_analytics
ANALYTICS_DB_USERNAME=your_username
ANALYTICS_DB_PASSWORD=your_password
ANALYTICS_DB_SSLMODE=prefer
```

### Step 3: Clear Config & Test

```bash
php artisan config:clear
php artisan analytics:test-connection
```

**Expected output:**
```
✅ Connection successful!
✅ SQLite connection still working correctly
✅ All checks passed! Analytics database is ready.
```

### Step 4: Verify Existing DB Still Works

```bash
php artisan tinker
```

```php
// Should still work
DB::connection('sqlite')->select('SELECT 1');
config('database.default'); // Should return 'sqlite'
```

## 📋 Files Created/Modified

1. **`config/database.php`** - Added `analytics_pg` connection
2. **`AWS_RDS_SETUP_GUIDE.md`** - Complete AWS setup instructions
3. **`app/Console/Commands/TestAnalyticsConnection.php`** - Test command
4. **`ANALYTICS_DB_SETUP_SUMMARY.md`** - Detailed summary
5. **`QUICK_START_ANALYTICS_DB.md`** - This file

## 🔒 Security Reminders

- ❌ **NEVER** use `0.0.0.0/0` in security group
- ✅ Restrict to your IP (`YOUR_IP/32`) or app server security group
- ✅ Use strong passwords
- ✅ Enable encryption on RDS

## ⚠️ Important

- **DO NOT** run migrations yet (wait for next task)
- **DO NOT** change `DB_CONNECTION` in `.env` (keep as `sqlite`)
- **DO NOT** modify existing database code

## 🆘 Troubleshooting

If connection fails, see `AWS_RDS_SETUP_GUIDE.md` troubleshooting section.

Common issues:
- Security group not allowing your IP
- Wrong endpoint/username/password
- RDS instance not running
- Network/VPC issues

