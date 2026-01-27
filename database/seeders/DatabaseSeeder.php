<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'phone_number' => '12341234',
            'password' => Hash::make(env('SEEDER_PASSWORD', 'password'))
        ]);

        // Test credentials for quick login
        // Phone number: 12345678
        // Password: test
        User::factory()->create([
            'name' => 'Testing User',
            'phone_number' => '12345678',
            'password' => Hash::make('test')
        ]);

        // Set admin user for Ali_houdeib@hotmail.com
        User::updateOrCreate(
            ['email' => 'Ali_houdeib@hotmail.com'],
            [
                'name' => 'Admin User',
                'is_admin' => true,
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]
        );

        $this->call([GameSeeder::class]);
    }
}
