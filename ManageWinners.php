<?php

namespace App\Filament\Resources\WinnerResource\Pages;

use App\Filament\Resources\WinnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWinners extends ManageRecords
{
    protected static string $resource = WinnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
