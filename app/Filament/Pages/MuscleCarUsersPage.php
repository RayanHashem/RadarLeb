<?php

namespace App\Filament\Pages;

use App\Models\Game;
use App\Models\GameUserStat;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MuscleCarUsersPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Muscle Car Users';

    protected static ?string $navigationGroup = 'Users';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament-panels::page';

    protected static ?Game $cachedGame = null;

    public function table(Table $table): Table
    {
        if (static::$cachedGame === null) {
            static::$cachedGame = Game::find(4);
        }
        $game = static::$cachedGame;
        
        return $table
            ->query(
                User::query()
                    ->where('game_id', 4)
                    ->selectRaw('users.*, COALESCE((
                        SELECT SUM(amount_spent) 
                        FROM game_user_stats 
                        WHERE game_user_stats.user_id = users.id 
                        AND game_user_stats.game_id = 4
                    ), 0) as radar_cash_spent')
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('radar_cash_spent')
                    ->label('RadarCash Spent')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('draw_number')
                    ->label('Draw Number')
                    ->getStateUsing(fn () => $game->draw_number ?? 'N/A'),
                Tables\Columns\TextColumn::make('prize')
                    ->label('Prize')
                    ->getStateUsing(fn () => $game->name ?? 'N/A'),
            ])
            ->paginated([10, 20, 50])
            ->defaultPaginationPageOption(10);
    }

    public function getTitle(): string
    {
        return 'Muscle Car Users';
    }

    public static function getRoutePath(): string
    {
        return '/users/muscle-car';
    }
}

