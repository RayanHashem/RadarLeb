# Prize-Specific User Pages Implementation

## Summary

Created 5 separate Filament pages under "Users" sidebar navigation, each filtering users by `game_id` for a specific prize category.

## Files Created

### 1. `app/Filament/Resources/UserResource/Pages/ListUsersMobile.php`
- **Prize:** Mobile (game_id = 1)
- **Navigation Label:** "Mobile"
- **Route:** `/admin/users/mobile`
- **Navigation Sort:** 1

### 2. `app/Filament/Resources/UserResource/Pages/ListUsersBikeElectronics.php`
- **Prize:** Bike Electronics (game_id = 2)
- **Navigation Label:** "Bike Electronics"
- **Route:** `/admin/users/bike-electronics`
- **Navigation Sort:** 2

### 3. `app/Filament/Resources/UserResource/Pages/ListUsersSUV.php`
- **Prize:** SUV (game_id = 3)
- **Navigation Label:** "SUV"
- **Route:** `/admin/users/suv`
- **Navigation Sort:** 3

### 4. `app/Filament/Resources/UserResource/Pages/ListUsersMuscleCar.php`
- **Prize:** Muscle Car (game_id = 4)
- **Navigation Label:** "Muscle Car"
- **Route:** `/admin/users/muscle-car`
- **Navigation Sort:** 4

### 5. `app/Filament/Resources/UserResource/Pages/ListUsersCashSuper.php`
- **Prize:** Cash/Super (game_id = 5)
- **Navigation Label:** "Cash/Super"
- **Route:** `/admin/users/cash-super`
- **Navigation Sort:** 5

## Files Modified

### `UserResource.php`
- Updated `getPages()` method to register all 5 prize-specific pages
- Removed the generic `by-prize` route

## Navigation Structure

All 5 pages are configured with:
- `protected static ?string $navigationParentItem = 'Users';` - Makes them appear under "Users" in sidebar
- `protected static ?int $navigationSort = X;` - Controls order (1-5)
- Each page appears as a submenu item under "Users"

## Table Columns Displayed

Each page displays the following columns:

1. **ID** - `users.id`
2. **Name** - `users.name` (searchable, sortable)
3. **Phone Number** - `users.phone_number` (searchable)
4. **Created At** - `users.created_at` (sortable, formatted as dateTime)
5. **RadarCash Spent** - Computed from `game_user_stats.amount_spent` (sortable)
6. **Draw Number** - `games.draw_number` for that prize
7. **Prize** - `games.name` for that prize

## Eloquent Queries Used

### Main Query (Filter Users by Prize)
```php
User::query()->where('game_id', $gameId)
```

### RadarCash Spent (Computed Column)
```php
GameUserStat::where('user_id', $record->id)
    ->where('game_id', $gameId)
    ->first()
    ->amount_spent ?? 0
```

**Exact Query Breakdown:**
- **Table:** `game_user_stats`
- **Conditions:**
  - `user_id = $record->id` (the user's ID)
  - `game_id = $gameId` (the prize's game_id: 1, 2, 3, 4, or 5)
- **Field:** `amount_spent`
- **Fallback:** Returns `0.00` if no record exists

### Draw Number
```php
Game::find($gameId)->draw_number ?? 'N/A'
```

### Prize Name
```php
Game::find($gameId)->name ?? 'N/A'
```

### Sortable Query for RadarCash Spent
```php
$query->leftJoin('game_user_stats', function ($join) use ($gameId) {
    $join->on('users.id', '=', 'game_user_stats.user_id')
         ->where('game_user_stats.game_id', '=', $gameId);
})
->orderBy('game_user_stats.amount_spent', $direction)
->select('users.*');
```

## Pagination Configuration

All pages use:
- **Options:** 10, 20, 50 per page
- **Default:** 10 per page
- **UI:** Shows "Showing 1 to X of Y results" (Filament default)

## Database Tables Used

### Primary Table
- `users` - Filtered by `game_id` column

### Joined/Related Tables
- `game_user_stats` - For `amount_spent` calculation
  - Columns: `user_id`, `game_id`, `amount_spent`
- `games` - For `draw_number` and `name`
  - Columns: `id`, `name`, `draw_number`

## Verification Steps

See `DATABASE_DEBUG_INSTRUCTIONS.md` for complete debug commands.

### Quick Verification in Tinker:
```php
// 1. Check SQLite file location
config('database.connections.sqlite.database')

// 2. Verify counts
\App\Models\User::count()
\App\Models\Game::count()
\App\Models\GameUserStat::count()

// 3. Test RadarCash spent query for Mobile (game_id = 1)
$user = \App\Models\User::where('game_id', 1)->first();
$stat = \App\Models\GameUserStat::where('user_id', $user->id)
    ->where('game_id', 1)
    ->first();
$stat->amount_spent ?? 0
```

## Expected Behavior

1. **Navigation:** All 5 prize pages appear as submenu items under "Users" in the sidebar
2. **Filtering:** Each page shows only users where `users.game_id` matches the prize's game_id
3. **RadarCash Spent:** Shows the correct `amount_spent` from `game_user_stats` for that user+prize combination
4. **Draw Number:** Shows the `draw_number` from the `games` table for that prize
5. **Prize Name:** Shows the prize name even on the filtered page
6. **Pagination:** Works correctly with 10/20/50 options

## Troubleshooting

### Issue: Pages not appearing in navigation
- **Check:** Ensure `navigationParentItem = 'Users'` matches the exact label of the Users resource
- **Verify:** Run `php artisan optimize:clear` to clear caches

### Issue: All RadarCash Spent shows 0.00
- **Check:** Verify `game_user_stats` table has records with matching `user_id` and `game_id`
- **Debug:** See `DATABASE_DEBUG_INSTRUCTIONS.md` Step 3

### Issue: Wrong users showing
- **Check:** Verify `users.game_id` values are correct (1-5)
- **Query:** `User::where('game_id', 1)->count()` should return expected count

---

**Implementation Date:** 2026-01-24
**No Migrations Created:** ✅ Confirmed
**Database Tables Used:** `users`, `game_user_stats`, `games` (existing only)

