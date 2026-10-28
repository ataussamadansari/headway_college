<?php

namespace App\Filament\Admin\Resources\Courses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Course Overview')
                    ->description('Essential course identification and current status')
                    ->icon('heroicon-o-academic-cap')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('code')
                            ->label('Course Code')
                            ->badge()
                            ->color('primary')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-m-tag'),
                        TextEntry::make('name')
                            ->label('Course Name')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('is_active')
                            ->label('Course Status')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Active Course' : 'Inactive')
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->icon(fn (bool $state): string => $state ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle'),
                    ]),

                Section::make('Capacity & Duration')
                    ->description('Enrolled vs available intake seat capacity')
                    ->icon('heroicon-o-users')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('duration')
                            ->label('Program Duration')
                            ->badge()
                            ->color('gray')
                            ->icon('heroicon-m-clock')
                            ->placeholder('Not Specified'),
                        TextEntry::make('total_seats')
                            ->label('Approved Seat Intake')
                            ->numeric()
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-m-check-badge'),
                        TextEntry::make('students_count')
                            ->label('Currently Enrolled')
                            ->state(fn ($record) => $record->students()->count())
                            ->badge()
                            ->color('success')
                            ->icon('heroicon-m-academic-cap'),
                    ]),

                Section::make('Course Description & Curriculum')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('No specific course description recorded.')
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
