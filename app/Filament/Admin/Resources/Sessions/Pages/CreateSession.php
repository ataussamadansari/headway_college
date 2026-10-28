<?php

namespace App\Filament\Admin\Resources\Sessions\Pages;

use App\Filament\Admin\Resources\Sessions\SessionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateSession extends CreateRecord
{
    protected static string $resource = SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Sessions')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
}
