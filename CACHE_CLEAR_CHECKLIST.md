# Cache Clear Checklist - Local Development

## Required Steps After Navigation Changes

Run these commands in order to clear all caches and ensure Filament picks up the new navigation structure:

```bash
# 1. Clear all optimization caches
php artisan optimize:clear

# 2. Clear view cache
php artisan view:clear

# 3. Clear route cache
php artisan route:clear

# 4. Clear config cache
php artisan config:clear

# 5. Restart the development server
# Stop current server (Ctrl+C), then:
php artisan serve
```

## Why Each Step is Needed

1. **`optimize:clear`** - Clears all cached files (config, routes, views, events, compiled)
2. **`view:clear`** - Clears compiled Blade templates
3. **`route:clear`** - Clears route cache (important for new page routes)
4. **`config:clear`** - Clears config cache (important for Filament panel config)
5. **Restart server** - Ensures Livewire components reload with new navigation

## Verification

After clearing caches and restarting:

1. Visit `/admin` and check sidebar
2. Under "Users" you should see:
   - All Users
   - Mobile Users
   - Bike Electronics Users
   - SUV Users
   - Muscle Car Users
   - Cash/Super Users
3. **"Users by Prize" should NOT appear**

## If Navigation Still Shows Old Items

If "Users by Prize" still appears after clearing caches:

1. Check browser cache (hard refresh: Ctrl+Shift+R or Ctrl+F5)
2. Verify `app/Filament/Pages/UsersByPrizePage.php` is deleted
3. Check `storage/framework/views/` for old compiled views (can delete entire directory)
4. Restart PHP-FPM if using production-like setup

---

**Note:** These commands are safe for local development. In production, use `php artisan config:cache` and `php artisan route:cache` after deployment.

