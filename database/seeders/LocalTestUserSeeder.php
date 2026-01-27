<?php

namespace Database\Seeders;

use App\Models\AdminPreApprovedUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class LocalTestUserSeeder extends Seeder
{
    /**
     * Create a local-only test admin user for development.
     * 
     * This seeder ONLY runs when APP_ENV=local to prevent
     * creating test users in production.
     */
    public function run(): void
    {
        // Only create test users in local environment
        if (app()->isLocal()) {
            // Create first test user: user@local.test
            $user1 = User::updateOrCreate(
                ['email' => 'user@local.test'],
                [
                    'name' => 'Local Test Admin',
                    'is_admin' => true,
                    'password' => Hash::make('pass'),
                ]
            );

            AdminPreApprovedUser::updateOrCreate(
                ['email' => 'user@local.test'],
                [
                    'name' => 'Local Test Admin',
                    'is_active' => true,
                    'approved_at' => now(),
                    'notes' => 'Auto-approved local test user',
                ]
            );

            // Create second test user: admin@admin.com
            $user2 = User::updateOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Admin Test User',
                    'is_admin' => true,
                    'password' => Hash::make('12341234'),
                ]
            );

            AdminPreApprovedUser::updateOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Admin Test User',
                    'is_active' => true,
                    'approved_at' => now(),
                    'notes' => 'Auto-approved local test user (admin@admin.com)',
                ]
            );

            $this->command->info('✅ Local test admin users created:');
            $this->command->info('   1. Email: user@local.test / Password: pass');
            $this->command->info('   2. Email: admin@admin.com / Password: 12341234');
            $this->command->info('   Both users are pre-approved and can access /admin');
        } else {
            $this->command->warn('⚠️  Skipping local test user creation (not in local environment)');
        }
    }
}

