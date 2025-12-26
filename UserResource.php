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
                    ->getStateUsing(fn (User $u) =>
                    GameUserStat::where('user_id', $u->id)->sum('amount_spent')
                    ),
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

                /** Change password */
                Tables\Actions\Action::make('changePwd')
                    ->label('Change Password')
                    ->icon('heroicon-o-key')
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->password()->required()->label('New password'),
                    ])
                    ->action(function (array $data, User $record) {
                        $record->update(['password' => Hash::make($data['password'])]);
                    }),
            ])
            ->headerActions([])   // no create button
            ->paginated(false);
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
