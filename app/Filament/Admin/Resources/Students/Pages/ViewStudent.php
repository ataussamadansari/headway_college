<?php

namespace App\Filament\Admin\Resources\Students\Pages;

use App\Filament\Admin\Resources\Students\StudentResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Students')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
            Action::make('print')
                ->label('Print Slip')
                ->icon('heroicon-o-printer')
                ->color('warning')
                ->url(fn ($record) => route('students.print-single', $record))
                ->openUrlInNewTab(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
