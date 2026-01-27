<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Game;
use App\Models\SystemSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Manage Prizes';

    protected static ?string $navigationGroup = 'Manage RadarLeb';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Prize';

    protected static ?string $pluralModelLabel = 'Prizes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('price_to_play')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Forms\Components\TextInput::make('minimum_amount_for_winning')
                    ->label('Amount to win')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Forms\Components\TextInput::make('draw_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('image_path')
                    ->label('Image Path')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_enabled')
                    ->label('Enabled')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('price')->money('USD'),
                TextColumn::make('price_to_play'),
                TextColumn::make('draw_number'),

                ToggleColumn::make('is_enabled'),

                TextColumn::make('minimum_amount_for_winning')
                    ->label('Amount to win'),

                // ⬇️ New per-user spend progress
                TextColumn::make('global_progress')
                    ->label('Pot Progress')
                    ->state(function (\App\Models\Game $record) {
                        $min = (float) ($record->minimum_amount_for_winning ?? 0);
                        $spent = (float) ($record->stats()->sum('amount_spent') ?? 0);

                        $percent = $min > 0 ? ($spent / $min) * 100 : 0;
                        $percent = (int) max(0, min(100, round($percent)));

                        $spentFmt = number_format($spent, 0);
                        $minFmt   = number_format($min, 0);

                        // Compact styles
                        $outerStyle = 'width:120px;margin:0 auto;'; // narrower
                        $labelStyle = 'font-size:11px;text-align:center;margin-bottom:2px;';
                        $trackStyle = 'width:100%;height:6px;border-radius:4px;background:#e5e7eb;overflow:hidden;';
                        $barStyle   = "height:6px;background:#3b82f6;width:{$percent}%;";

                        return <<<HTML
            <div style="{$outerStyle}">
                <div style="{$labelStyle}">{$spentFmt}/{$minFmt}</div>
                <div style="{$trackStyle}">
                    <div style="{$barStyle}"></div>
                </div>
            </div>
        HTML;
                    })
                    ->html()
                    ->alignCenter()

            ])
            ->headerActions([
                Action::make('toggleRadar')
                    ->label(fn () => SystemSetting::get('scans_enabled', true) ? 'Disable Radar' : 'Enable Radar')
                    ->color(fn () => SystemSetting::get('scans_enabled', true) ? 'danger' : 'success')
                    ->action(function () {
                        $new = ! SystemSetting::get('scans_enabled', true);
                        SystemSetting::put('scans_enabled', $new);
                    }),
            ])
            ->actions([
                EditAction::make()->modalHeading('Edit Prize')
                    ->modalSubmitActionLabel('Save')
                    ->slideOver(),
            ])
            ->paginated([10, 20, 50])
            ->defaultPaginationPageOption(10);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            // Sum of ALL users' amount_spent for each game
            ->withSum('stats as total_amount_spent', 'amount_spent');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
