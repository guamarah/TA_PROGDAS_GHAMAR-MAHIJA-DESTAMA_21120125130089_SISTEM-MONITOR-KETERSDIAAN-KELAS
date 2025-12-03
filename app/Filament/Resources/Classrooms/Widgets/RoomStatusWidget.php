<?php

namespace App\Filament\Resources\Classrooms\Widgets;

use App\Models\Classroom;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class RoomStatusWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static bool $is_lazy = false;
    protected ?string $pollingInterval = '10s';
    protected ?string $heading = 'Status Ruangan Saat Ini';

   protected function getStats(): array
{
    $classrooms = Classroom::with('schedules')->get();
    $stats = [];
    $now = Carbon::now()->format('H:i:s');

    foreach ($classrooms as $classroom) {

        // Jadwal terbaru berdasarkan start_time
        $currentSchedule = $classroom->schedules
            ->sortByDesc('start_time')
            ->first();

        // Default values
        $value = 'KOSONG';
        $color = Color::Green;
        $description = "Tidak ada jadwal";

        if ($currentSchedule) {
            // CEK STATUS MANUAL DARI DATABASE
            switch ($currentSchedule->status) {
                case 'on-going':
                    $value = 'SEDANG DIPAKAI';
                    $color = Color::Red;
                    $description = "On-Going sejak " . substr($currentSchedule->start_time, 0, 5);
                    break;

                case 'scheduled':
                    $value = 'KOSONG';
                    $color = Color::Yellow;
                    $description = "Akan dipakai: " . substr($currentSchedule->start_time, 0, 5);
                    break;

                case 'completed':
                    $value = 'SELESAI';
                    $color = Color::Blue;
                    $description = "Selesai pada " . substr($currentSchedule->end_time, 0, 5);
                    break;

                case 'canceled':
                    $value = 'DIBATALKAN';
                    $color = Color::Gray;
                    $description = "Jadwal dibatalkan";
                    break;
            }
        }

        $stats[] = Stat::make(
            "{$classroom->name} ({$classroom->code})",
            $value
        )
            ->description($description)
            ->color($color);
    }

    return $stats;
}


} 