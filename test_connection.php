<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "Testing database connection...\n";
    echo "Default connection: " . config('database.default') . "\n";
    echo "Testing PostgreSQL connection explicitly...\n\n";
    
    // Test PostgreSQL connection explicitly
    $result = DB::connection('pgsql')->select('SELECT 1 as ok, version() as pg_version, current_database() as current_db');
    
    if (!empty($result)) {
        echo "✅ Connection successful!\n\n";
        echo "Database Information:\n";
        echo "  PostgreSQL Version: " . $result[0]->pg_version . "\n";
        echo "  Current Database: " . $result[0]->current_db . "\n";
        echo "  Test Query Result: " . $result[0]->ok . "\n";
    } else {
        echo "❌ Connection failed: No result returned\n";
        exit(1);
    }
} catch (\Exception $e) {
    echo "❌ Connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "  1. Check if PostgreSQL extension is enabled: php -m | findstr pdo_pgsql\n";
    echo "  2. Verify .env file has correct database credentials\n";
    echo "  3. Check AWS RDS security group allows your IP\n";
    exit(1);
}

