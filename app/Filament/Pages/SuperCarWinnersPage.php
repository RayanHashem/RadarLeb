<?php

namespace App\Filament\Pages;

use App\Models\Game;
use App\Models\Winner;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class SuperCarWinnersPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Super Car Winners';

    protected static ?string $navigationGroup = 'Winners';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament-panels::page';

    protected static ?Game $cachedGame = null;

    public function table(Table $table): Table
    {
        if (static::$cachedGame === null) {
            static::$cachedGame = Game::find(5); // Cash game_id = 5
        }
        $game = static::$cachedGame;
        
        $query = $game 
            ? Winner::query()->where('game_name', 'LIKE', '%' . $game->name . '%')
            : Winner::query()->whereRaw('1 = 0'); // No results if game not found
        
        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('game_name')
                    ->label('Prize Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('draw')
                    ->label('Draw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date/Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated([10, 20, 50])
            ->defaultPaginationPageOption(10);
    }

    public function getTitle(): string
    {
        return 'Super Car Winners';
    }

    public static function getRoutePath(): string
    {
        return '/winners/super-car';
    }
}

