<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AnalyticsOverview;
use App\Filament\Widgets\PrizeBreakdownWidget;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PrizesAnalyticsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Prizes';

    protected static ?string $navigationGroup = 'Prizes';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.prizes-analytics-page';

    public function mount(): void
    {
        // Log database path on each page load (local env only) to track consistency
        if (app()->environment('local')) {
            $dbPath = config('database.connections.sqlite.database');
            $defaultConnection = config('database.default');
            $gameCount = \App\Models\Game::count();
            
            Log::info('PrizesAnalyticsPage DB Check', [
                'default_connection' => $defaultConnection,
                'sqlite_database' => $dbPath,
                'game_count' => $gameCount,
            ]);
        }
    }

    protected function getHeaderWidgets(): array
    {
        try {
            return [
                AnalyticsOverview::class,
            ];
        } catch (\Exception $e) {
            Log::error('PrizesAnalyticsPage: Error loading header widgets', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Return empty array on error - widgets will handle their own error states
            return [];
        }
    }

    protected function getFooterWidgets(): array
    {
        try {
            return [
                PrizeBreakdownWidget::class,
            ];
        } catch (\Exception $e) {
            Log::error('PrizesAnalyticsPage: Error loading footer widgets', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Return empty array on error - widgets will handle their own error states
            return [];
        }
    }

    public function getTitle(): string
    {
        return 'Prizes Analytics';
    }
}

