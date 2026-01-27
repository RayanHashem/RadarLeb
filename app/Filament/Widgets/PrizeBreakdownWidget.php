<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class PrizeBreakdownWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        try {
            // Query prize configuration data directly from games table
            // NO analytics aggregates - just prize config fields
            $query = Game::query()
                ->select([
                    'games.id',
                    'games.name',
                    'games.price',
                    'games.price_to_play',
                    'games.draw_number',
                    'games.is_enabled',
                    'games.minimum_amount_for_winning',
                ])
                ->orderBy('games.name');
            
            return $table
                ->query($query)
                ->columns([
                    Tables\Columns\TextColumn::make('name')
                        ->label('Prize')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('price')
                        ->label('Price')
                        ->money('USD')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('price_to_play')
                        ->label('Price to Play')
                        ->money('USD')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('draw_number')
                        ->label('Draw Number')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\IconColumn::make('is_enabled')
                        ->label('Is enabled')
                        ->boolean()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('minimum_amount_for_winning')
                        ->label('Amount for winning')
                        ->money('USD')
                        ->sortable(),
                ])
                ->defaultSort('name', 'asc')
                ->paginated([10, 25, 50])
                ->defaultPaginationPageOption(10);
        } catch (\Exception $e) {
            Log::error('PrizeBreakdownWidget error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Return empty query on error
            return $table
                ->query(Game::whereRaw('1 = 0')) // Empty result set
                ->columns([
                    Tables\Columns\TextColumn::make('name')
                        ->label('Error loading data'),
                ]);
        }
    }

    public function getHeading(): string
    {
        return 'Prize Breakdown';
    }
}
