<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\GameUserStat;
use App\Models\Scan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyticsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $startTime = microtime(true);
        
        try {
            // Cache key with short TTL (5 minutes) for analytics
            $cacheKey = 'analytics_overview_stats';
            $cacheTTL = now()->addMinutes(5);
            
            return Cache::remember($cacheKey, $cacheTTL, function () use ($startTime) {
                $checkpoint = microtime(true);
                
                // Log query start
                $queryLog = [];
                DB::listen(function ($query) use (&$queryLog) {
                    $queryLog[] = [
                        'sql' => $query->sql,
                        'time' => $query->time,
                    ];
                });
                
                $sevenDaysAgo = now()->subDays(7);
                $today = now()->startOfDay();
                
                // OPTIMIZED: Single query for total users
                $totalUsers = User::count();
                $checkpoint = logTiming('total_users', $checkpoint);
                
                // OPTIMIZED: Use subquery instead of whereHas to avoid N+1
                // Active users (users with scans in last 7 days)
                $activeUsers = User::whereIn('id', function ($query) use ($sevenDaysAgo) {
                    $query->select('user_id')
                        ->from('scans')
                        ->where('created_at', '>=', $sevenDaysAgo)
                        ->distinct();
                })->count();
                $checkpoint = logTiming('active_users', $checkpoint);
                
                // OPTIMIZED: Direct count with date filter
                $scansToday = Scan::whereDate('created_at', $today)->count();
                $checkpoint = logTiming('scans_today', $checkpoint);
                
                // OPTIMIZED: Direct count with date filter
                $scansLast7Days = Scan::where('created_at', '>=', $sevenDaysAgo)->count();
                $checkpoint = logTiming('scans_last_7_days', $checkpoint);
                
                // OPTIMIZED: Single query for both counts
                $scanStats = Scan::selectRaw('
                    COUNT(*) as total_scans,
                    SUM(CASE WHEN success = 1 THEN 1 ELSE 0 END) as successful_scans
                ')->first();
                
                $totalScans = $scanStats->total_scans ?? 0;
                $successfulScans = $scanStats->successful_scans ?? 0;
                $successRate = $totalScans > 0 ? round(($successfulScans / $totalScans) * 100, 2) : 0;
                $checkpoint = logTiming('success_rate', $checkpoint);
                
                // OPTIMIZED: Single SUM query with index on amount_spent
                $revenue = GameUserStat::sum('amount_spent');
                $checkpoint = logTiming('revenue', $checkpoint);
                
                $totalTime = microtime(true) - $startTime;
                
                // Log slow queries
                $slowQueries = array_filter($queryLog, fn($q) => $q['time'] > 100); // > 100ms
                if (!empty($slowQueries) || $totalTime > 1.0) {
                    Log::warning('AnalyticsOverview slow queries detected', [
                        'total_time' => round($totalTime, 3),
                        'slow_queries' => $slowQueries,
                        'all_queries' => $queryLog,
                    ]);
                }
                
                return [
                    Stat::make('Total Users', number_format($totalUsers))
                        ->description('All registered users')
                        ->descriptionIcon('heroicon-m-users')
                        ->color('primary'),
                    Stat::make('Active Users', number_format($activeUsers))
                        ->description('Scans in last 7 days')
                        ->descriptionIcon('heroicon-m-user-group')
                        ->color('success'),
                    Stat::make('Scans Today', number_format($scansToday))
                        ->description("Last 7 days: {$scansLast7Days}")
                        ->descriptionIcon('heroicon-m-signal')
                        ->color('info'),
                    Stat::make('Success Rate', $successRate . '%')
                        ->description("{$successfulScans} of {$totalScans} scans")
                        ->descriptionIcon('heroicon-m-check-circle')
                        ->color($successRate >= 50 ? 'success' : 'warning'),
                    Stat::make('Total Revenue', '$' . number_format($revenue, 2))
                        ->description('From all game plays')
                        ->descriptionIcon('heroicon-m-currency-dollar')
                        ->color('success'),
                ];
            });
        } catch (\Exception $e) {
            Log::error('AnalyticsOverview error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Return safe defaults on error
            return [
                Stat::make('Error', 'Unable to load analytics')
                    ->description('Please try refreshing the page')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger'),
            ];
        }
    }
}

// Helper function for timing
if (!function_exists('logTiming')) {
    function logTiming(string $label, float $lastCheckpoint): float
    {
        $now = microtime(true);
        $elapsed = ($now - $lastCheckpoint) * 1000; // Convert to milliseconds
        
        if ($elapsed > 100) { // Log if > 100ms
            Log::debug("AnalyticsOverview timing: {$label}", [
                'elapsed_ms' => round($elapsed, 2),
            ]);
        }
        
        return $now;
    }
}
