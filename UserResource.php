<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\GameUserStat;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone_number')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('wallet_balance'),
                Tables\Columns\TextColumn::make('amount_spent')
                    ->label('Amount Spent')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make(),
                    ])
                    ->getStateUsing(function (User $record) {
                        return GameUserStat::where('user_id', $record->id)->sum('amount_spent');
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->leftJoin('game_user_stats', 'users.id', '=', 'game_user_stats.user_id')
                            ->groupBy('users.id')
                            ->orderByRaw('COALESCE(SUM(game_user_stats.amount_spent), 0) ' . $direction)
                            ->select('users.*');
                    }),
            ])
            ->actions([
                /** Add-to-wallet */
                Tables\Actions\Action::make('addWallet')
                    ->label('Add to Wallet')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->numeric()->minValue(1)->required()->label('Amount'),
                    ])
                    ->action(function (array $data, User $record) {
                        $record->increment('wallet_balance', $data['amount']);
                    }),
            ])
            ->headerActions([])   // no create button
            ->paginated([10, 20, 50])
            ->defaultPaginationPageOption(10);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
