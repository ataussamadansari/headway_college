<?php

namespace App\Filament\Admin\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Registration & Course')
                        ->description('Enrollment details & IDs')
                        ->icon('heroicon-o-academic-cap')
                        ->columns(3)
                        ->schema([
                            TextInput::make('college_register_no')
                                ->label('College Register No')
                                ->default(fn () => 'HC-REG-' . date('Y') . '-' . strtoupper(Str::random(5)))
                                ->required()
                                ->unique(ignoreRecord: true),
                            TextInput::make('control_no')
                                ->label('Control No')
                                ->default(fn () => 'CTRL-' . date('Y') . '-' . rand(1000, 9999))
                                ->required()
                                ->unique(ignoreRecord: true),
                            DatePicker::make('registration_date')
                                ->label('Registration Date')
                                ->default(now())
                                ->required(),
                            Select::make('course_id')
                                ->label('Course')
                                ->relationship('course', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('session_id')
                                ->label('Academic Session')
                                ->relationship('session', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),

                    Step::make('Personal Details')
                        ->description('Student & family information')
                        ->icon('heroicon-o-user')
                        ->columns(3)
                        ->schema([
                            TextInput::make('name')
                                ->label('Student Full Name')
                                ->required(),
                            TextInput::make('father_name')
                                ->label("Father's Name")
                                ->required(),
                            TextInput::make('mother_name')
                                ->label("Mother's Name")
                                ->required(),
                            Select::make('gender')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                    'other' => 'Other',
                                ])
                                ->required(),
                            DatePicker::make('dob')
                                ->label('Date of Birth')
                                ->required(),
                            TextInput::make('religion')
                                ->default('Hindu'),
                            Select::make('category')
                                ->options([
                                    'General' => 'General',
                                    'OBC' => 'OBC',
                                    'SC' => 'SC',
                                    'ST' => 'ST',
                                    'EWS' => 'EWS',
                                ])
                                ->default('General'),
                            Toggle::make('domicile_up')
                                ->label('Domicile in UP?')
                                ->default(true),
                            Toggle::make('is_handicap')
                                ->label('Physically Handicapped?')
                                ->default(false),
                        ]),

                    Step::make('Contact & Address')
                        ->description('Communication information')
                        ->icon('heroicon-o-phone')
                        ->columns(2)
                        ->schema([
                            TextInput::make('mobile')
                                ->label('Mobile Number')
                                ->tel()
                                ->prefix('+91')
                                ->required(),
                            TextInput::make('pincode')
                                ->label('Postal Pincode')
                                ->numeric()
                                ->length(6)
                                ->required(),
                            Textarea::make('address')
                                ->label('Permanent Address')
                                ->rows(3)
                                ->columnSpanFull()
                                ->required(),
                        ]),

                    Step::make('Photo & Signature')
                        ->description('Upload required documents')
                        ->icon('heroicon-o-camera')
                        ->columns(2)
                        ->schema([
                            FileUpload::make('photo_path')
                                ->label('Student Photograph')
                                ->image()
                                ->directory('students/photos')
                                ->disk('public')
                                ->visibility('public')
                                ->imageEditor(),
                            FileUpload::make('signature_path')
                                ->label('Student Signature')
                                ->image()
                                ->directory('students/signatures')
                                ->disk('public')
                                ->visibility('public')
                                ->imageEditor(),
                        ]),

                    Step::make('Qualifications')
                        ->description('Academic history & marks')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            Repeater::make('educationalQualifications')
                                ->relationship('educationalQualifications')
                                ->columns(4)
                                ->defaultItems(1)
                                ->schema([
                                    Select::make('qualification_type')
                                        ->label('Level')
                                        ->options([
                                            'highschool' => 'High School (10th)',
                                            'intermediate' => 'Intermediate (12th)',
                                            'ug' => 'Under Graduate (UG)',
                                            'other' => 'Other',
                                        ])
                                        ->required(),
                                    TextInput::make('board_university')
                                        ->label('Board / University')
                                        ->required(),
                                    TextInput::make('stream')
                                        ->label('Stream')
                                        ->placeholder('Science, Commerce, Arts')
                                        ->required(),
                                    TextInput::make('year_of_completion')
                                        ->label('Year')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('roll_number')
                                        ->label('Roll Number')
                                        ->required(),
                                    TextInput::make('max_marks')
                                        ->label('Max Marks')
                                        ->numeric()
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            $max = (float) $state;
                                            $obt = (float) $get('obtained_marks');
                                            if ($max > 0 && $obt > 0) {
                                                $set('percentage', round(($obt / $max) * 100, 2));
                                            }
                                        }),
                                    TextInput::make('obtained_marks')
                                        ->label('Obtained Marks')
                                        ->numeric()
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            $obt = (float) $state;
                                            $max = (float) $get('max_marks');
                                            if ($max > 0 && $obt > 0) {
                                                $set('percentage', round(($obt / $max) * 100, 2));
                                            }
                                        }),
                                    TextInput::make('percentage')
                                        ->label('Percentage (%)')
                                        ->readOnly(),
                                ]),
                        ]),
                ])
                ->skippable()
                ->columnSpanFull(),
            ]);
    }
}
