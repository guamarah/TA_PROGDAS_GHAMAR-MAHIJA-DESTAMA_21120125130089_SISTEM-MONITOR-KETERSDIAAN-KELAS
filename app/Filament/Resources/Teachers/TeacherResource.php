<?php

namespace App\Filament\Resources\Teachers;

use Filament\Tables;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Resources\Teachers\Tables\TeachersTable;
use App\Models\Teacher;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema)
        ->schema([
            //
            Forms\Components\TextInput::make('name')
                ->label('Nama Dosen')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->label('Telepon')
                ->maxLength(20),
            Forms\Components\TextInput::make('department')
                ->label('Departemen')
                ->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table)
        ->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Dosen')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('email')->label('Email')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('phone')->label('Telepon')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('department')->label('Departemen')->sortable()->searchable(),
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
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
            'index' => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }
}
