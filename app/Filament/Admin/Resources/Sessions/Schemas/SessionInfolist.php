<?php

namespace App\Filament\Admin\Resources\Sessions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Academic Session Overview')
                    ->description('Primary session status and student enrollment numbers')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Academic Session')
                            ->badge()
                            ->color('info')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('is_active')
                            ->label('Session Status')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Active Session' : 'Inactive Session')
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->icon(fn (bool $state): string => $state ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle'),
                        TextEntry::make('students_count')
                            ->label('Enrolled Students')
                            ->state(fn ($record) => $record->students()->count())
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-m-academic-cap'),
                    ]),

                Section::make('Timeline & Dates')
                    ->description('Session validity duration and important milestone dates')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('start_date')
                            ->label('Start Date')
                            ->date('d M Y')
                            ->icon('heroicon-m-play'),
                        TextEntry::make('end_date')
                            ->label('End Date')
                            ->date('d M Y')
                            ->icon('heroicon-m-flag'),
                    ]),

                Section::make('Remarks & Notes')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->schema([
                        TextEntry::make('remarks')
                            ->label('Remarks')
                            ->placeholder('No specific remarks recorded for this academic session.')
                            ->columnSpanFull(),
                    ]),

                Section::make('System Audit')
                    ->description('Timestamps and tracking metadata')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created On')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
