<?php

namespace App\Filament\Pages;

use App\Models\Winner;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class AllWinnersPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'All Winners';

    protected static ?string $navigationGroup = 'Winners';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament-panels::page';

    public function table(Table $table): Table
    {
        return $table
            ->query(Winner::query())
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
        return 'All Winners';
    }

    public static function getRoutePath(): string
    {
        return '/winners/all';
    }
}

