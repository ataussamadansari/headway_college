<?php

namespace App\Filament\Admin\Resources\Students\Tables;

use App\Filament\Admin\Resources\Students\Pages\EditStudent;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Student $record): string => EditStudent::getUrl(['record' => $record]))
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Photo')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                TextColumn::make('college_register_no')
                    ->label('Register No')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('session.name')
                    ->label('Session')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('mobile')
                    ->label('Mobile')
                    ->searchable()
                    ->icon('heroicon-m-phone'),
                TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'male' => 'primary',
                        'female' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('registration_date')
                    ->label('Reg. Date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('father_name')
                    ->label("Father's Name")
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course_id')
                    ->label('Filter by Course')
                    ->relationship('course', 'name'),
                SelectFilter::make('session_id')
                    ->label('Filter by Session')
                    ->relationship('session', 'name'),
                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                Action::make('print')
                    ->label('Print Slip')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->url(fn (Student $record): string => route('students.print-single', $record))
                    ->openUrlInNewTab(),
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(route('students.export'))
                    ->openUrlInNewTab(),
                Action::make('print_list')
                    ->label('Print Report')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->url(route('students.print'))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
