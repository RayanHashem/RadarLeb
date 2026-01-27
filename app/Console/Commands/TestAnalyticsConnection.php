<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestAnalyticsConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:test-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test connection to analytics PostgreSQL database without affecting existing SQLite database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Testing analytics PostgreSQL connection...');
        $this->newLine();

        // Check if connection is configured
        $host = config('database.connections.analytics_pg.host');
        $database = config('database.connections.analytics_pg.database');
        $username = config('database.connections.analytics_pg.username');

        if (empty($host) || empty($database) || empty($username)) {
            $this->error('❌ Analytics database connection not configured!');
            $this->warn('Please add ANALYTICS_DB_* variables to your .env file.');
            $this->newLine();
            $this->info('Required variables:');
            $this->line('  - ANALYTICS_DB_HOST');
            $this->line('  - ANALYTICS_DB_DATABASE');
            $this->line('  - ANALYTICS_DB_USERNAME');
            $this->line('  - ANALYTICS_DB_PASSWORD');
            $this->line('  - ANALYTICS_DB_PORT (optional, defaults to 5432)');
            return Command::FAILURE;
        }

        $this->info('Connection configuration found:');
        $this->line("  Host: {$host}");
        $this->line("  Database: {$database}");
        $this->line("  Username: {$username}");
        $this->line("  Port: " . config('database.connections.analytics_pg.port', '5432'));
        $this->newLine();

        // Test connection
        try {
            $this->info('Attempting to connect...');
            
            $result = DB::connection('analytics_pg')->select('SELECT 1 as test, version() as pg_version, current_database() as current_db');
            
            if (!empty($result)) {
                $this->newLine();
                $this->info('✅ Connection successful!');
                $this->newLine();
                $this->info('Database Information:');
                $this->line("  PostgreSQL Version: {$result[0]->pg_version}");
                $this->line("  Current Database: {$result[0]->current_db}");
                $this->newLine();
                
                // Verify existing SQLite connection still works
                $this->info('Verifying existing SQLite connection is unaffected...');
                $sqliteResult = DB::connection('sqlite')->select('SELECT 1 as test');
                
                if (!empty($sqliteResult)) {
                    $this->info('✅ SQLite connection still working correctly');
                    $this->newLine();
                }
                
                $this->info('✅ All checks passed! Analytics database is ready.');
                return Command::SUCCESS;
            } else {
                $this->error('❌ Connection failed: No result returned');
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ Connection failed!');
            $this->error("Error: {$e->getMessage()}");
            $this->newLine();
            
            // Log the error for debugging
            Log::error('Analytics connection test failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            $this->warn('Troubleshooting tips:');
            $this->line('  1. Verify AWS RDS security group allows your IP on port 5432');
            $this->line('  2. Check that ANALYTICS_DB_HOST, USERNAME, PASSWORD are correct');
            $this->line('  3. Ensure RDS instance is running and accessible');
            $this->line('  4. Check AWS RDS console for instance status');
            $this->newLine();
            
            return Command::FAILURE;
        }
    }
}

