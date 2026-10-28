<?php

namespace App\Filament\Admin\Resources\Students\Schemas;

use Filament\Infolists\Components\IconEntry;
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
                Section::make('Student Identification')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('college_register_no')
                            ->label('College Register No')
                            ->copyable()
                            ->weight('bold'),
                        TextEntry::make('control_no')
                            ->label('Control No')
                            ->copyable(),
                        TextEntry::make('registration_date')
                            ->label('Registration Date')
                            ->date(),
                        TextEntry::make('course.name')
                            ->label('Enrolled Course')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('session.name')
                            ->label('Academic Session')
                            ->badge()
                            ->color('info'),
                    ]),

                Section::make('Personal & Contact Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name'),
                        TextEntry::make('father_name')
                            ->label("Father's Name"),
                        TextEntry::make('mother_name')
                            ->label("Mother's Name"),
                        TextEntry::make('gender')
                            ->badge(),
                        TextEntry::make('dob')
                            ->label('Date of Birth')
                            ->date(),
                        TextEntry::make('mobile')
                            ->icon('heroicon-m-phone'),
                        TextEntry::make('religion')
                            ->placeholder('-'),
                        TextEntry::make('category')
                            ->placeholder('-'),
                        TextEntry::make('pincode'),
                        IconEntry::make('domicile_up')
                            ->label('Domicile in UP')
                            ->boolean(),
                        IconEntry::make('is_handicap')
                            ->label('Physically Handicapped')
                            ->boolean(),
                        TextEntry::make('address')
                            ->columnSpanFull(),
                    ]),

                Section::make('Documents')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo_path')
                            ->label('Student Photo')
                            ->disk('public'),
                        ImageEntry::make('signature_path')
                            ->label('Student Signature')
                            ->disk('public'),
                    ]),

                Section::make('Educational Qualifications')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('educationalQualifications')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('qualification_type')
                                    ->label('Level')
                                    ->badge(),
                                TextEntry::make('board_university')
                                    ->label('Board / University'),
                                TextEntry::make('stream')
                                    ->label('Stream'),
                                TextEntry::make('year_of_completion')
                                    ->label('Year'),
                                TextEntry::make('roll_number')
                                    ->label('Roll No'),
                                TextEntry::make('obtained_marks')
                                    ->label('Obtained Marks'),
                                TextEntry::make('max_marks')
                                    ->label('Max Marks'),
                                TextEntry::make('percentage')
                                    ->label('Percentage')
                                    ->suffix('%')
                                    ->badge()
                                    ->color('success'),
                            ]),
                    ]),
            ]);
    }
}
