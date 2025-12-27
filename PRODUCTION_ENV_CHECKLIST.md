# Production Environment Checklist (AWS)

## ⚠️ CRITICAL: Environment Variables for AWS Production

### Required Production Settings

**MUST be set in production `.env` file on AWS:**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-production-domain.com
```

### Why These Settings Matter

1. **`APP_ENV=production`**
   - Ensures Laravel runs in production mode
   - Disables debug features
   - Optimizes performance
   - **Prevents DevAutoAuth middleware from running** (only runs when `APP_ENV=local`)

2. **`APP_DEBUG=false`**
   - Hides error details from users
   - Prevents sensitive information leakage
   - Required for security compliance

3. **`APP_URL`**
   - Must match your production domain
   - Used for generating absolute URLs
   - Required for proper asset loading

---

## DevAutoAuth Safety Layers

The `DevAutoAuth` middleware has **multiple safety layers** to prevent execution in production:

### Layer 1: Environment Check
```php
if (!app()->environment('local')) {
    return $next($request); // Exit immediately
}
```
- Only runs when `APP_ENV=local`
- **Will NOT run if `APP_ENV=production`**

### Layer 2: Host-Based Check (Extra Safety)
```php
$isProductionHost = str_contains($host, '.com') 
    || str_contains($host, '.net') 
    || str_contains($host, '.org')
    || str_contains($host, 'amazonaws.com')
    || str_contains($host, 'elasticbeanstalk.com')
    || str_contains($host, 'cloudfront.net');
```
- Even if `APP_ENV=local` is misconfigured, refuses to run on:
  - Production domains (`.com`, `.net`, `.org`, `.io`)
  - AWS domains (`amazonaws.com`, `elasticbeanstalk.com`, `cloudfront.net`)

### Layer 3: Not Registered
- Middleware is **NOT registered** in `bootstrap/app.php`
- Even if all checks pass, middleware won't execute unless explicitly registered

---

## Verification Steps for AWS Deployment

### 1. Check Environment Variables
```bash
# SSH into your AWS instance and verify:
echo $APP_ENV        # Should output: production
echo $APP_DEBUG      # Should output: false
```

### 2. Verify .env File
```bash
# On AWS server, check .env file:
grep APP_ENV .env    # Should show: APP_ENV=production
grep APP_DEBUG .env  # Should show: APP_DEBUG=false
```

### 3. Test DevAutoAuth is Disabled
```bash
# Check if middleware is registered (should return nothing):
grep -r "DevAutoAuth" bootstrap/app.php routes/ app/Providers/
```

### 4. Verify Host Check
- Access your production site
- Check server logs - DevAutoAuth should not execute
- Even if `APP_ENV=local` is accidentally set, host check will prevent execution

---

## Common Mistakes to Avoid

### ❌ DO NOT:
- Set `APP_ENV=local` in production
- Set `APP_DEBUG=true` in production
- Register `DevAutoAuth` middleware in `bootstrap/app.php`
- Use production domain with `APP_ENV=local`

### ✅ DO:
- Always set `APP_ENV=production` on AWS
- Always set `APP_DEBUG=false` on AWS
- Keep `DevAutoAuth` unregistered
- Use environment-specific `.env` files

---

## AWS-Specific Configuration

### Elastic Beanstalk
```bash
# Set environment variables in EB console or .ebextensions:
option_settings:
  aws:elasticbeanstalk:application:environment:
    APP_ENV: production
    APP_DEBUG: false
```

### EC2 / ECS
```bash
# In your deployment script or .env file:
export APP_ENV=production
export APP_DEBUG=false
```

### CloudFormation / Terraform
```yaml
# Example CloudFormation:
Environment:
  Variables:
    APP_ENV: production
    APP_DEBUG: false
```

---

## Emergency Response

If `APP_ENV=local` is accidentally set in production:

1. **Immediate Action:**
   ```bash
   # On AWS server, update .env:
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Restart Application:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   # Restart your web server/application
   ```

3. **Verify:**
   - DevAutoAuth host check will still prevent execution
   - But fix the environment variable immediately

---

## Summary

✅ **Production is SAFE if:**
- `APP_ENV=production` is set
- `APP_DEBUG=false` is set
- `DevAutoAuth` is not registered (current state)
- Host-based check provides extra protection

🔒 **Multiple layers of protection ensure DevAutoAuth cannot run in production.**

