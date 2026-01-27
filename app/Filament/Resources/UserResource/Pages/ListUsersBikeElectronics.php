<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Game;
use App\Models\GameUserStat;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListUsersBikeElectronics extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected static bool $shouldRegisterNavigation = false;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->where('game_id', 2);
    }

    public function table(Table $table): Table
    {
        $game = Game::find(2);
        
        return $table
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
                    ->getStateUsing(function ($record) {
                        $amount = GameUserStat::where('user_id', $record->id)
                            ->where('game_id', 2)
                            ->sum('amount_spent');
                        return number_format($amount, 2);
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->leftJoin('game_user_stats', function ($join) {
                            $join->on('users.id', '=', 'game_user_stats.user_id')
                                 ->where('game_user_stats.game_id', '=', 2);
                        })
                        ->orderBy('game_user_stats.amount_spent', $direction)
                        ->select('users.*');
                    }),
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
        return 'Users - Bike Electronics';
    }
}

