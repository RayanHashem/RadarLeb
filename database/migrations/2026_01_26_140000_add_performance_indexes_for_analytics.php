<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adds critical indexes for analytics queries to prevent timeouts.
     * These indexes optimize:
     * - Date range queries on scans.created_at
     * - Boolean filters on scans.success
     * - Aggregate queries on game_user_stats.amount_spent
     * - Foreign key lookups
     */
    public function up(): void
    {
        // Indexes for scans table (used heavily in analytics)
        Schema::table('scans', function (Blueprint $table) {
            // Index for date filtering (used in AnalyticsOverview)
            if (!$this->indexExists('scans', 'scans_created_at_index')) {
                $table->index('created_at', 'scans_created_at_index');
            }
            
            // Index for success filtering
            if (!$this->indexExists('scans', 'scans_success_index')) {
                $table->index('success', 'scans_success_index');
            }
            
            // Composite index for date + success queries
            if (!$this->indexExists('scans', 'scans_created_at_success_index')) {
                $table->index(['created_at', 'success'], 'scans_created_at_success_index');
            }
            
            // Index for game_id lookups (used in PrizeBreakdownWidget)
            if (!$this->indexExists('scans', 'scans_game_id_index')) {
                $table->index('game_id', 'scans_game_id_index');
            }
            
            // Composite index for game_id + created_at
            if (!$this->indexExists('scans', 'scans_game_id_created_at_index')) {
                $table->index(['game_id', 'created_at'], 'scans_game_id_created_at_index');
            }
        });
        
        // Indexes for game_user_stats table
        Schema::table('game_user_stats', function (Blueprint $table) {
            // Index for amount_spent SUM queries (critical for revenue calculations)
            if (!$this->indexExists('game_user_stats', 'game_user_stats_amount_spent_index')) {
                $table->index('amount_spent', 'game_user_stats_amount_spent_index');
            }
            
            // Index for game_id lookups
            if (!$this->indexExists('game_user_stats', 'game_user_stats_game_id_index')) {
                $table->index('game_id', 'game_user_stats_game_id_index');
            }
            
            // Composite index for game_id + user_id (for distinct user counts)
            if (!$this->indexExists('game_user_stats', 'game_user_stats_game_id_user_id_index')) {
                $table->index(['game_id', 'user_id'], 'game_user_stats_game_id_user_id_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scans', function (Blueprint $table) {
            $table->dropIndex('scans_created_at_index');
            $table->dropIndex('scans_success_index');
            $table->dropIndex('scans_created_at_success_index');
            $table->dropIndex('scans_game_id_index');
            $table->dropIndex('scans_game_id_created_at_index');
        });
        
        Schema::table('game_user_stats', function (Blueprint $table) {
            $table->dropIndex('game_user_stats_amount_spent_index');
            $table->dropIndex('game_user_stats_game_id_index');
            $table->dropIndex('game_user_stats_game_id_user_id_index');
        });
    }
    
    /**
     * Check if an index exists (SQLite compatible)
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $database = $connection->getDatabaseName();
        
        if ($connection->getDriverName() === 'sqlite') {
            // SQLite: Check if index exists
            $indexes = $connection->select("
                SELECT name FROM sqlite_master 
                WHERE type='index' AND name=?
            ", [$indexName]);
            
            return !empty($indexes);
        } else {
            // MySQL/PostgreSQL: Use information_schema
            $result = $connection->select("
                SELECT COUNT(*) as count 
                FROM information_schema.statistics 
                WHERE table_schema = ? AND table_name = ? AND index_name = ?
            ", [$database, $table, $indexName]);
            
            return ($result[0]->count ?? 0) > 0;
        }
    }
};

