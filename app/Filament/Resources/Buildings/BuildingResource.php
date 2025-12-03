<?php

namespace App\Filament\Resources\Buildings;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\Buildings\Pages\CreateBuilding;
use App\Filament\Resources\Buildings\Pages\EditBuilding;
use App\Filament\Resources\Buildings\Pages\ListBuildings;
use App\Filament\Resources\Buildings\Schemas\BuildingForm;
use App\Filament\Resources\Buildings\Tables\BuildingsTable;
use App\Models\Building;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables;


class BuildingResource extends Resource
{
    protected static ?string $model = Building::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    public static function form(Schema $schema): Schema
    {
        return BuildingForm::configure($schema)
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Gedung')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('address')
                ->label('Alamat')
                ->required()
                ->maxLength(100),
               
            Forms\Components\TextInput::make('floors')
                ->label('Lantai')
                ->required()
                ->numeric()
                ->maxLength(10),
            Forms\Components\Textarea::make('description')
                ->maxLength(1000),
        ]);
    }

    public static function table(Table $table): Table
{
    return BuildingsTable::configure($table)
        ->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Gedung')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('address')->label('Alamat')->searchable(),
            Tables\Columns\TextColumn::make('floors')->label('Lantai')->sortable(),
        ])
        ->actions([
            EditAction::make()
                ->visible(fn ($record) => !$record->trashed()),  // hanya muncul untuk record aktif
            DeleteAction::make(),                                  // soft delete
            Action::make('restore')
                ->label('Restore')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('success')
                ->visible(fn ($record) => $record->trashed())    // hanya muncul untuk record yang dihapus
                ->action(fn ($record) => $record->restore()),
                
        ]);
}

    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->withTrashed();
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
            'index' => ListBuildings::route('/'),
            'create' => CreateBuilding::route('/create'),
            'edit' => EditBuilding::route('/{record}/edit'),
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
