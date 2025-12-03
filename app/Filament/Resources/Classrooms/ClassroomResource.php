<?php

namespace App\Filament\Resources\Classrooms;

use App\Filament\Resources\Classrooms\Pages\CreateClassroom;
use App\Filament\Resources\Classrooms\Pages\EditClassroom;
use App\Filament\Resources\Classrooms\Pages\ListClassrooms;
use App\Filament\Resources\Classrooms\Schemas\ClassroomForm;
use App\Filament\Resources\Classrooms\Tables\ClassroomsTable;
use App\Models\Classroom;
use BackedEnum;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables;
use Filament\Forms;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;

use Filament\Tables\Filters\TrashedFilter;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    public static function form(Schema $schema): Schema
    {
        return ClassroomForm::configure($schema)
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Ruangan Kelas')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('code')
                ->label('Kode Ruangan')
                ->required()
                ->maxLength(100),
            Forms\Components\Select::make('building_id')
                ->label('Gedung')
                ->relationship('building', 'name')
                ->required(),
            Forms\Components\TextInput::make('capacity')
                ->label('Kapasitas')
                ->required()
                ->numeric(),
            Forms\Components\Textarea::make('description')
                ->maxLength(1000),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ClassroomsTable::configure($table)
        ->columns([
            Tables\Columns\TextColumn::make('name')->label('Ruangan Kelas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('code')->label('Kode Ruangan')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('building.name')->label('Gedung')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('capacity')->label('Kapasitas')->sortable(),
        ])
        ->filters([
        
            TrashedFilter::make(),
        ])
        ->actions([
          
            EditAction::make(), 
            DeleteAction::make(), 
            RestoreAction::make(), 
            ForceDeleteAction::make(), 
        ])
        ->bulkActions([
           
            BulkActionGroup::make([ 
                DeleteBulkAction::make(), 
                
                RestoreBulkAction::make(), 
                ForceDeleteBulkAction::make(), 
            ]),
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
            'index' => ListClassrooms::route('/'),
            'create' => CreateClassroom::route('/create'),
            'edit' => EditClassroom::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}