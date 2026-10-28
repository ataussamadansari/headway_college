<?php

namespace App\Filament\Admin\Resources\Students\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admission & Identification')
                    ->description('Registration numbers and enrollment program')
                    ->icon('heroicon-o-identification')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('college_register_no')
                            ->label('College Register No')
                            ->copyable()
                            ->weight('bold')
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-m-identification'),
                        TextEntry::make('control_no')
                            ->label('Control Number')
                            ->copyable()
                            ->badge()
                            ->color('gray')
                            ->icon('heroicon-m-hashtag'),
                        TextEntry::make('registration_date')
                            ->label('Registration Date')
                            ->date('d M Y')
                            ->icon('heroicon-m-calendar'),
                        TextEntry::make('course.name')
                            ->label('Enrolled Course')
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-m-academic-cap'),
                        TextEntry::make('session.name')
                            ->label('Academic Session')
                            ->badge()
                            ->color('success')
                            ->icon('heroicon-m-clock'),
                    ]),

                Section::make('Personal Details')
                    ->description('Student and parent background information')
                    ->icon('heroicon-o-user')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Student Full Name')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('father_name')
                            ->label("Father's Name"),
                        TextEntry::make('mother_name')
                            ->label("Mother's Name"),
                        TextEntry::make('gender')
                            ->label('Gender')
                            ->badge()
                            ->color(fn (string $state): string => match (strtolower($state)) {
                                'male' => 'info',
                                'female' => 'success',
                                default => 'gray',
                            }),
                        TextEntry::make('dob')
                            ->label('Date of Birth')
                            ->date('d M Y')
                            ->icon('heroicon-m-cake'),
                        TextEntry::make('religion')
                            ->label('Religion')
                            ->placeholder('Not Specified'),
                        TextEntry::make('category')
                            ->label('Caste Category')
                            ->badge()
                            ->color('warning')
                            ->placeholder('General'),
                        TextEntry::make('domicile_up')
                            ->label('UP Domicile')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Yes (UP Resident)' : 'No (Other State)')
                            ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                        TextEntry::make('is_handicap')
                            ->label('Physically Challenged')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Yes (Handicap)' : 'No')
                            ->color(fn (bool $state): string => $state ? 'danger' : 'gray'),
                    ]),

                Section::make('Contact & Address')
                    ->description('Communication channels and postal coordinates')
                    ->icon('heroicon-o-phone')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('mobile')
                            ->label('Mobile Phone')
                            ->icon('heroicon-m-phone')
                            ->copyable(),
                        TextEntry::make('pincode')
                            ->label('Postal Pincode')
                            ->icon('heroicon-m-map-pin')
                            ->badge()
                            ->color('gray'),
                        TextEntry::make('address')
                            ->label('Permanent Residence Address')
                            ->columnSpanFull(),
                    ]),

                Section::make('Uploaded Documents')
                    ->description('Official student photo and signature verification')
                    ->icon('heroicon-o-camera')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo_path')
                            ->label('Student Photograph')
                            ->disk('public')
                            ->height(180)
                            ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record?->name ?? 'Student') . '&background=0D47A1&color=fff&size=256'),
                        ImageEntry::make('signature_path')
                            ->label('Student Signature')
                            ->disk('public')
                            ->height(100),
                    ]),

                Section::make('Academic Qualifications & Marks History')
                    ->description('Previous educational qualifications and calculated percentages')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('educationalQualifications')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('qualification_type')
                                    ->label('Level')
                                    ->badge()
                                    ->color('primary'),
                                TextEntry::make('board_university')
                                    ->label('Board / University'),
                                TextEntry::make('stream')
                                    ->label('Stream'),
                                TextEntry::make('year_of_completion')
                                    ->label('Year Passed'),
                                TextEntry::make('roll_number')
                                    ->label('Roll Number')
                                    ->copyable(),
                                TextEntry::make('obtained_marks')
                                    ->label('Obtained Marks')
                                    ->numeric(),
                                TextEntry::make('max_marks')
                                    ->label('Max Marks')
                                    ->numeric(),
                                TextEntry::make('percentage')
                                    ->label('Percentage')
                                    ->suffix('%')
                                    ->badge()
                                    ->color('success')
                                    ->weight('bold'),
                            ]),
                    ]),

                Section::make('System Audit')
                    ->description('Registration timestamps and metadata')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Registered On')
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
