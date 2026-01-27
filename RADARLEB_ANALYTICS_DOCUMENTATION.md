# RadarLeb Application Analytics Documentation

## Part A: Core Application Flows

### 1. User Registration/Login

**Flow:**
- Users register via `/register` (Laravel Breeze/Inertia)
- Login via `/login` (standard Laravel auth)
- Authentication handled by `AuthenticatedSessionController`
- Users can login with email or phone number

**Models:** `User`

### 2. Wallet/Top-Up System

**Current Implementation:**
- Wallet balance stored directly on `users.wallet_balance` (string/decimal)
- **No separate transactions table exists**
- Wallet top-ups appear to be manual (admin adds via Filament `UserResource`)
- No Whish integration found in codebase
- No deposit request/approval system found

**Admin Action:**
- Filament `UserResource` has "Add to Wallet" action
- Direct increment: `$user->increment('wallet_balance', $amount)`

**Models:** `User` (wallet_balance field)

### 3. Prize Selection

**Flow:**
- User selects a prize/game from dashboard
- Prize selection stored in `users.game_id`
- API endpoint: `POST /me/game` (updates `game_id`)
- Minimum balance requirements per prize:
  - Mobile (ID 1): 0
  - Bike/Electronics (ID 2): 4
  - SUV (ID 3): 8
  - Muscle Car (ID 4): 24
  - Super Car/Cash (ID 5): 32

**Models:** `User` (game_id), `Game`

### 4. "Scan for Antenna" Gameplay Loop

**Flow:**
1. User selects a game/prize
2. User clicks "Scan" button
3. API: `POST /api/games/{game}/scan`
4. System checks:
   - Game is enabled (`games.is_enabled`)
   - Scans are enabled (`system_settings.scans_enabled`)
   - User has sufficient balance (`wallet_balance >= price_to_play`)
5. Deducts `price_to_play` from wallet
6. **Antenna Generation Logic:**
   - Increments `fails_in_level` counter
   - Calculates `neededFails = (current_radar + 1) * 10 + random(-2, 2)`
   - If `fails_in_level >= neededFails`: 50% chance of success
   - On success: increments `current_radar` (max 6), resets `fails_in_level`
   - On failure: increments `failed_scans`
7. Creates `Scan` record
8. Updates `GameUserStat` record

**Models:** `Game`, `Scan`, `GameUserStat`, `User`, `SystemSetting`

### 5. Win Condition & Prize Fulfillment

**Win Condition:**
- User must reach `current_radar = 6` (3 antennas = radar levels 4, 5, 6)
- User must be in top 3 spenders for that game (`amount_spent` ranking)
- Total game spending must meet `games.minimum_amount_for_winning`

**Prize Fulfillment:**
- Winners stored in `winners` table
- Fields: `game_name`, `user_name`, `phone_number`, `email`, `draw`
- No automated fulfillment system found

**Models:** `Winner`, `GameUserStat`, `Game`

## Part B: Database Structure

### Tables & Relationships

#### `users`
**Key Columns:**
- `id`, `name`, `email`, `phone_number`
- `wallet_balance` (string/decimal, default 0)
- `game_id` (foreign key to games, default 1)
- `is_admin` (boolean)
- `password`, `remember_token`
- `email_verified_at`, `created_at`, `updated_at`

**Relationships:**
- `hasMany(Scan)`
- `hasMany(GameUserStat)`
- `belongsTo(Game)` via `game_id`

#### `games`
**Key Columns:**
- `id`, `name`
- `price` (decimal 10,2) - prize value
- `image_path` (string, nullable)
- `price_to_play` (integer, default 1) - cost per scan
- `minimum_amount_for_winning` (integer, default 1)
- `draw_number` (string, default '1')
- `is_enabled` (boolean, default true)
- `created_at`, `updated_at`

**Relationships:**
- `hasMany(Scan)`
- `hasMany(GameUserStat)`
- `hasMany(User)` via `game_id`

#### `scans`
**Key Columns:**
- `id`
- `user_id` (foreign key to users)
- `game_id` (foreign key to games)
- `success` (boolean, default false) - antenna detected
- `radar_level` (tinyint, default 0) - current radar level (0-6)
- `cost` (decimal 10,2, default 0) - amount charged
- `created_at`, `updated_at`

**Relationships:**
- `belongsTo(User)`
- `belongsTo(Game)`

#### `game_user_stats`
**Key Columns:**
- `id`
- `user_id` (foreign key to users)
- `game_id` (foreign key to games)
- `current_radar` (tinyint, default 0) - current level (0-6)
- `failed_scans` (unsigned int, default 0)
- `successful_scans` (unsigned int, default 0)
- `amount_spent` (decimal 12,2, default 0)
- `fails_in_level` (unsigned int, default 0) - counter for current level
- `created_at`, `updated_at`

**Relationships:**
- `belongsTo(User)`
- `belongsTo(Game)`

#### `winners`
**Key Columns:**
- `id`
- `game_name` (string)
- `user_name` (string)
- `phone_number` (string, nullable)
- `email` (string, nullable)
- `draw` (string, nullable)
- `created_at`, `updated_at`

**Relationships:**
- None (denormalized data)

#### `system_settings`
**Key Columns:**
- `key` (string, primary)
- `value` (json)
- No timestamps

**Usage:**
- `scans_enabled` - controls if scanning is active

#### `admin_login_audits`
**Key Columns:**
- `id`, `email_entered`, `user_id` (nullable), `ip_address`, `user_agent`
- `success` (boolean), `failure_reason` (nullable)
- `logged_in_at` (timestamp, nullable)
- `created_at`, `updated_at`

#### `admin_pre_approved_users`
**Key Columns:**
- `id`, `email` (unique), `name`, `notes`
- `is_active` (boolean), `approved_at`, `approved_by` (nullable)
- `created_at`, `updated_at`

## Part C: Analytics Capabilities

### Currently Available Analytics

#### User Analytics
- Total users (`users.count()`)
- Active users (users with scans)
- Users by game selection (`users.groupBy('game_id')`)
- Wallet balances distribution
- Registration trends (`users.groupBy('created_at')`)

#### Gameplay Analytics
- Total scans (`scans.count()`)
- Success rate (`scans.where('success', true).count() / scans.count()`)
- Scans per user (`scans.groupBy('user_id')`)
- Scans per game (`scans.groupBy('game_id')`)
- Average scans to win (users who reached radar 6)
- Revenue per game (`game_user_stats.sum('amount_spent')`)

#### Financial Analytics
- Total revenue (`game_user_stats.sum('amount_spent')`)
- Revenue per game
- Revenue per user
- Average spend per user
- Wallet balance totals (`users.sum('wallet_balance')`)
- **Note:** No transaction history - only current balances

#### Win Analytics
- Total winners (`winners.count()`)
- Winners per game (`winners.groupBy('game_name')`)
- Winners per draw (`winners.groupBy('draw')`)

#### Progress Analytics
- Users by radar level (`game_user_stats.groupBy('current_radar')`)
- Users close to winning (radar 5-6)
- Top spenders per game (`game_user_stats.orderBy('amount_spent')`)

### Missing Analytics (No Data Available)

#### Transaction History
- **Missing:** `wallet_transactions` table
- **Cannot track:** Deposit history, withdrawal history, transaction types
- **Impact:** Cannot analyze wallet top-up patterns, refunds, or transaction sources

#### User Behavior
- **Missing:** User session tracking
- **Cannot track:** Session duration, page views, user journey
- **Impact:** Limited user engagement metrics

#### Antenna Generation
- **Missing:** Detailed antenna generation logs
- **Cannot track:** Exact probability calculations, random seed values
- **Impact:** Cannot audit fairness or analyze probability patterns

#### Prize Fulfillment
- **Missing:** Fulfillment status, delivery tracking
- **Cannot track:** Prize delivery status, fulfillment time
- **Impact:** Cannot measure fulfillment efficiency

#### Marketing/Attribution
- **Missing:** Referral tracking, campaign tracking
- **Cannot track:** User acquisition sources, campaign effectiveness
- **Impact:** No marketing ROI analysis

#### Real-time Events
- **Missing:** Event logging system
- **Cannot track:** Real-time user actions, A/B test results
- **Impact:** Limited real-time analytics

## Recommendations for Enhanced Analytics

### High Priority
1. **Wallet Transactions Table**
   - Track all wallet changes (deposits, withdrawals, scan costs)
   - Enable transaction history and audit trail

2. **User Sessions Table**
   - Track login/logout times
   - Calculate session duration
   - Identify active vs inactive users

3. **Event Logging System**
   - Log key user actions (scan attempts, prize selections, etc.)
   - Enable detailed user journey analysis

### Medium Priority
4. **Prize Fulfillment Tracking**
   - Track fulfillment status
   - Delivery timestamps
   - Fulfillment method

5. **Campaign/Referral Tracking**
   - Track user acquisition sources
   - Referral codes
   - Campaign attribution

### Low Priority
6. **Antenna Generation Audit Log**
   - Log random seed values
   - Probability calculations
   - Fairness verification

