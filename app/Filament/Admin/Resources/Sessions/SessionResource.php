<?php

namespace App\Filament\Admin\Resources\Sessions;

use App\Filament\Admin\Resources\Sessions\Pages\CreateSession;
use App\Filament\Admin\Resources\Sessions\Pages\EditSession;
use App\Filament\Admin\Resources\Sessions\Pages\ListSessions;
use App\Filament\Admin\Resources\Sessions\Pages\ViewSession;
use App\Filament\Admin\Resources\Sessions\Schemas\SessionForm;
use App\Filament\Admin\Resources\Sessions\Schemas\SessionInfolist;
use App\Filament\Admin\Resources\Sessions\Tables\SessionsTable;
use App\Models\Session;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|UnitEnum|null $navigationGroup = 'Academic Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSessions::route('/'),
            'create' => CreateSession::route('/create'),
            'view' => ViewSession::route('/{record}'),
            'edit' => EditSession::route('/{record}/edit'),
        ];
    }
}
