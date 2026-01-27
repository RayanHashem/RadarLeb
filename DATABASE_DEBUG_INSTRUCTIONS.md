# Database Debug Instructions - SQLite Verification

## Step 1: Confirm SQLite Database File Location

Run this in Laravel Tinker to see which SQLite database file is being used:

```bash
php artisan tinker
```

Then execute:
```php
config('database.connections.sqlite.database')
```

**Expected Output:** Should show the full path to your SQLite database file, e.g.:
```
"C:\Users\rayan\Desktop\Radarleb coding\database\database.sqlite"
```

## Step 2: Verify Table Counts

In the same tinker session, run these commands to verify data exists:

```php
// Count records in each table
\App\Models\User::count()
\App\Models\Game::count()
\App\Models\Scan::count()
\App\Models\GameUserStat::count()

// Verify games exist
\App\Models\Game::all(['id', 'name'])

// Check if game_user_stats has data
\App\Models\GameUserStat::count()
\App\Models\GameUserStat::where('game_id', 1)->count()
\App\Models\GameUserStat::where('game_id', 1)->sum('amount_spent')
```

## Step 3: Verify Prize User List Query

Test the exact query used in the prize pages:

```php
// Test for Mobile (game_id = 1)
$users = \App\Models\User::where('game_id', 1)->get();
$users->count();

// For each user, check their amount_spent for game_id = 1
foreach ($users->take(5) as $user) {
    $stat = \App\Models\GameUserStat::where('user_id', $user->id)
        ->where('game_id', 1)
        ->first();
    echo "User {$user->id} ({$user->name}): amount_spent = " . ($stat ? $stat->amount_spent : '0.00') . "\n";
}
```

## Step 4: Verify Game Data

```php
// Check all games
\App\Models\Game::all(['id', 'name', 'draw_number'])

// Verify specific game
$game = \App\Models\Game::find(1);
$game->name;
$game->draw_number;
```

## Step 5: Check Database File Exists

From command line (PowerShell):
```powershell
Test-Path database\database.sqlite
Get-Item database\database.sqlite | Select-Object FullName, Length, LastWriteTime
```

## Common Issues

### Issue: All amount_spent values show 0.00
**Possible Causes:**
1. `game_user_stats` table is empty
2. `game_id` doesn't match between `users.game_id` and `game_user_stats.game_id`
3. Users haven't made any scans yet

**Debug:**
```php
// Check if game_user_stats has any records
\App\Models\GameUserStat::count()

// Check if there are stats for game_id = 1
\App\Models\GameUserStat::where('game_id', 1)->get(['user_id', 'game_id', 'amount_spent'])

// Check a specific user's stats across all games
$userId = 1; // Replace with actual user ID
\App\Models\GameUserStat::where('user_id', $userId)->get(['game_id', 'amount_spent'])
```

### Issue: Wrong database file being used
**Check:**
```php
// In tinker
config('database.connections.sqlite.database')
DB::connection()->getDatabaseName()
```

**Fix:** Ensure `.env` file has:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## Expected Results

After running the debug commands, you should see:
- ✅ SQLite file path matches your project location
- ✅ User count > 0
- ✅ Game count = 5 (or more)
- ✅ GameUserStat records exist with amount_spent > 0 for at least some users
- ✅ Prize pages show correct amount_spent values (not all 0.00)

