<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Administrator Profile')
                    ->description('User credentials and system access identity')
                    ->icon('heroicon-o-user-circle')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-m-user'),
                        TextEntry::make('email')
                            ->label('Email Address')
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        TextEntry::make('email_verified_at')
                            ->label('Verification Status')
                            ->badge()
                            ->formatStateUsing(fn ($state): string => $state ? 'Email Verified' : 'Unverified')
                            ->color(fn ($state): string => $state ? 'success' : 'warning')
                            ->icon(fn ($state): string => $state ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle'),
                    ]),

                Section::make('System Activity & Timestamps')
                    ->description('Account creation and modification history')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Account Created')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Last Activity / Updated')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
