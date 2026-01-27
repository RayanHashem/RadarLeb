# AWS RDS PostgreSQL Setup Guide for RadarLeb Analytics

## Overview

This guide walks you through setting up an AWS RDS PostgreSQL instance for analytics **without affecting the existing SQLite production database**. The analytics database will be a separate connection that can be used alongside the existing database.

## Prerequisites

- AWS Account with appropriate permissions
- Access to AWS Console
- Your current IP address (for temporary testing access)

## Step 1: Create RDS PostgreSQL Instance

### 1.1 Navigate to RDS Console

1. Log in to [AWS Console](https://console.aws.amazon.com/)
2. Search for "RDS" in the services search bar
3. Click on **RDS** service

### 1.2 Create Database

1. Click **"Create database"** button (orange button, top right)
2. Choose **"Standard create"** (not Easy create, for more control)

### 1.3 Database Configuration

**Engine options:**
- **Engine type:** PostgreSQL
- **Version:** Select latest stable version (e.g., PostgreSQL 15.x or 16.x)
- **Templates:**
  - For **dev/testing:** Choose **"Free tier"** (if eligible) or **"Dev/Test"**
  - For **production:** Choose **"Production"**

**Settings:**
- **DB instance identifier:** `radarleb-analytics-dev` (or your preferred name)
- **Master username:** `radarleb_admin` (or your preferred username)
- **Master password:** 
  - Click **"Auto generate a password"** OR
  - Enter a strong password (save it securely - you'll need it for `.env`)
  - ⚠️ **IMPORTANT:** Save the password immediately if auto-generated

**Instance configuration:**
- **DB instance class:** 
  - For dev/testing: `db.t3.micro` (free tier eligible) or `db.t3.small`
  - For production: `db.t3.medium` or larger based on needs
- **Storage:**
  - **Storage type:** General Purpose SSD (gp3)
  - **Allocated storage:** 20 GB (minimum, adjust as needed)
  - **Storage autoscaling:** Enable if needed (optional)

### 1.4 Connectivity

**VPC and networking:**
- **Virtual private cloud (VPC):** 
  - If you have an existing VPC for your app server, select it
  - If not, use the default VPC
- **Subnet group:** Use default or create new
- **Public access:** 
  - For **testing:** Set to **"Yes"** (temporary - we'll secure with security group)
  - For **production:** Set to **"No"** (use VPC peering or VPN)
- **VPC security group:** 
  - Choose **"Create new"**
  - Name: `radarleb-analytics-sg`
  - ⚠️ **We'll configure this in Step 2**

**Database authentication:**
- **Password authentication:** Selected (default)

### 1.5 Additional Configuration

**Database options:**
- **Initial database name:** `radarleb_analytics`
- **DB parameter group:** Use default
- **Backup:**
  - **Automated backups:** Enable (recommended)
  - **Backup retention period:** 7 days (adjust as needed)
- **Encryption:**
  - **Enable encryption:** Recommended (especially for production)
- **Monitoring:**
  - **Enhanced monitoring:** Optional (has cost)

### 1.6 Create Database

1. Review all settings
2. Click **"Create database"**
3. ⚠️ **Wait for creation** (takes 5-15 minutes)
4. **Save the endpoint URL** shown on the details page (e.g., `radarleb-analytics-dev.xxxxx.us-east-1.rds.amazonaws.com`)

## Step 2: Configure Security Group (CRITICAL)

### 2.1 Navigate to Security Group

1. In RDS console, click on your database instance
2. Under **"Connectivity & security"** tab, find **"VPC security groups"**
3. Click on the security group name (e.g., `radarleb-analytics-sg`)

### 2.2 Edit Inbound Rules

1. Click **"Edit inbound rules"**
2. Click **"Add rule"**
3. Configure the rule:

**For Testing (Temporary - Your IP only):**
- **Type:** PostgreSQL
- **Protocol:** TCP
- **Port:** 5432
- **Source:** 
  - **Custom** → Enter your current IP address (find at [whatismyip.com](https://whatismyip.com))
  - Format: `YOUR_IP/32` (e.g., `203.0.113.1/32`)
- **Description:** "Temporary access from my IP for testing"

**For Production (App Server Security Group):**
- **Type:** PostgreSQL
- **Protocol:** TCP
- **Port:** 5432
- **Source:** 
  - **Custom** → Select your app server's security group ID
  - OR enter the security group ID directly (e.g., `sg-xxxxxxxxx`)
- **Description:** "Access from app server security group"

4. Click **"Save rules"**

⚠️ **CRITICAL SECURITY NOTES:**
- ❌ **NEVER** use `0.0.0.0/0` (allows access from anywhere)
- ✅ **ALWAYS** restrict to specific IP or security group
- ✅ For production, use security group-based access, not IP-based

### 2.3 Edit Outbound Rules (Optional)

Usually not needed, but verify outbound rules allow responses:
- Default outbound rules (allow all) are usually fine

## Step 3: Get Connection Details

After database creation completes:

1. In RDS console, click on your database instance
2. Under **"Connectivity & security"** tab, note:
   - **Endpoint:** `radarleb-analytics-dev.xxxxx.us-east-1.rds.amazonaws.com`
   - **Port:** `5432`
   - **Database name:** `radarleb_analytics`
   - **Username:** `radarleb_admin` (or what you set)
   - **Password:** (the one you saved)

## Step 4: Configure Laravel (.env)

Add these lines to your `.env` file (do NOT modify existing DB_CONNECTION):

```env
# Existing database (DO NOT CHANGE)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Analytics PostgreSQL Connection (NEW)
ANALYTICS_DB_CONNECTION=pgsql
ANALYTICS_DB_HOST=radarleb-analytics-dev.xxxxx.us-east-1.rds.amazonaws.com
ANALYTICS_DB_PORT=5432
ANALYTICS_DB_DATABASE=radarleb_analytics
ANALYTICS_DB_USERNAME=radarleb_admin
ANALYTICS_DB_PASSWORD=your_secure_password_here
ANALYTICS_DB_SSLMODE=prefer
```

**Replace:**
- `radarleb-analytics-dev.xxxxx.us-east-1.rds.amazonaws.com` with your actual endpoint
- `radarleb_admin` with your actual username
- `your_secure_password_here` with your actual password

## Step 5: Verify Connection

### 5.1 Clear Config Cache

```bash
php artisan config:clear
```

### 5.2 Test Connection via Tinker

```bash
php artisan tinker
```

Then run:
```php
DB::connection('analytics_pg')->select('SELECT 1 as test');
```

**Expected output:**
```
=> [
     {#1234
       +"test": 1,
     },
   ]
```

If you see this, the connection is working! ✅

### 5.3 Alternative: Test Connection Command

You can also use the test command we created:

```bash
php artisan analytics:test-connection
```

## Step 6: Verify Existing Database Still Works

**CRITICAL:** Verify your existing SQLite database still works:

```bash
php artisan tinker
```

```php
// Test existing SQLite connection
DB::connection('sqlite')->select('SELECT 1 as test');

// Verify default connection still uses SQLite
config('database.default'); // Should return 'sqlite'
```

## Troubleshooting

### Connection Timeout

**Problem:** Cannot connect to RDS instance

**Solutions:**
1. **Check Security Group:**
   - Verify inbound rule allows port 5432
   - Verify source IP/security group is correct
   - For IP-based: Your IP may have changed (check [whatismyip.com](https://whatismyip.com))

2. **Check Public Access:**
   - If using public access, ensure it's enabled in RDS settings
   - If using private access, ensure you're on the same VPC or using VPN

3. **Check Network ACLs:**
   - Verify VPC network ACLs allow traffic

### Authentication Failed

**Problem:** "password authentication failed"

**Solutions:**
1. Verify username and password in `.env` match RDS credentials
2. Check for extra spaces or special characters
3. Reset master password in RDS console if needed

### SSL Connection Error

**Problem:** SSL connection issues

**Solutions:**
1. Set `ANALYTICS_DB_SSLMODE=require` in `.env` (instead of `prefer`)
2. Or set `ANALYTICS_DB_SSLMODE=disable` for testing (NOT recommended for production)

## Security Best Practices

1. ✅ **Use Security Groups:** Restrict access to specific security groups, not IPs
2. ✅ **Enable Encryption:** Use RDS encryption at rest
3. ✅ **Regular Backups:** Enable automated backups
4. ✅ **Strong Passwords:** Use complex passwords (20+ characters)
5. ✅ **Rotate Credentials:** Change passwords periodically
6. ✅ **Monitor Access:** Enable CloudWatch logging
7. ❌ **Never use 0.0.0.0/0:** Never allow access from anywhere

## Cost Considerations

**Free Tier (if eligible):**
- `db.t3.micro` instance
- 20 GB storage
- 750 hours/month

**Estimated Monthly Cost (outside free tier):**
- `db.t3.small`: ~$15-20/month
- `db.t3.medium`: ~$30-40/month
- Storage: ~$0.10/GB/month
- Data transfer: Varies

**Cost Optimization:**
- Use `db.t3.micro` for dev/testing
- Stop instance when not in use (dev only)
- Use reserved instances for production (1-year commitment = ~40% savings)

## Next Steps

After connection is verified:
1. ✅ Connection works
2. ⏭️ **DO NOT run migrations yet** (wait for next task)
3. ⏭️ Plan analytics table structure
4. ⏭️ Set up data sync strategy

## Summary

- ✅ RDS PostgreSQL instance created
- ✅ Security group configured (restricted access)
- ✅ Laravel connection configured (`analytics_pg`)
- ✅ Connection verified
- ✅ Existing SQLite database unaffected

