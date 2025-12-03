<?php

namespace App\Filament\Resources\Schedules;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\Schedules\Pages\CreateSchedule;
use App\Filament\Resources\Schedules\Pages\EditSchedule;
use App\Filament\Resources\Schedules\Pages\ListSchedules;
use App\Filament\Resources\Schedules\Schemas\ScheduleForm;
use App\Filament\Resources\Schedules\Tables\SchedulesTable;
use App\Models\Schedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QueueList;

    public static function form(Schema $schema): Schema
    {
        return ScheduleForm::configure($schema)
        ->schema([
            Forms\Components\Select::make('building_id')
                ->label('Gedung')
                ->relationship('building', 'name')
                ->required(),
            Forms\Components\Select::make('classroom.code')
                 ->label('Kode Ruangan')
                 ->relationship('classroom', 'code')
                 ->required(),
               

            Forms\Components\Select::make('classroom_id')
                ->label('Ruangan Kelas')
                ->relationship('classroom', 'name')
                ->required(),
            Forms\Components\Select::make('teacher_id')
                ->label('Dosen')
                ->relationship('teacher', 'name')
                ->required(),
            Forms\Components\Select::make('day_of_week')
                ->options([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',       
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ])
                ->required(),
            Forms\Components\TimePicker::make('start_time')
                ->required(),
            Forms\Components\TimePicker::make('end_time')
                ->required(),
          
            Forms\Components\Select::make('status')
                ->options([
                    'scheduled' => 'Scheduled',
                    'on-going' => 'On-going',
                    'completed' => 'Completed',
                ])
                ->default('scheduled')
                ->required(),
            Forms\Components\Textarea::make('notes')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return SchedulesTable::configure($table)
        ->columns([
            Tables\Columns\TextColumn::make('building.name')->label('Gedung')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('classroom.code')
             ->label('Kode Ruangan')
             ->sortable()
             ->searchable(),

            Tables\Columns\TextColumn::make('classroom.name')->label('Ruangan Kelas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('teacher.name')->label('Dosen')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('day_of_week')->label('Hari')->sortable(),
            Tables\Columns\TextColumn::make('start_time')->label('Waktu Mulai')->time()->sortable(),
            Tables\Columns\TextColumn::make('end_time')->label('Waktu Selesai')->time()->sortable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->sortable()->searchable(),
          
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
            'index' => ListSchedules::route('/'),
            'create' => CreateSchedule::route('/create'),
            'edit' => EditSchedule::route('/{record}/edit'),
        ];
    }
}
