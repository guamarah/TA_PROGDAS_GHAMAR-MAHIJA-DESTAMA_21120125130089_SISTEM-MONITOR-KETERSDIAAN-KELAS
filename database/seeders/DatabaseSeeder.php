<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User (Guru)
        User::factory(5)->create();

        // 2. Buat Building
        // Panggil factory dengan jumlah yang diinginkan (contoh: 4 gedung)
        Building::factory(4)->create(); 
        
        // Selanjutnya, Anda bisa membuat Classroom yang terhubung (jika sudah siap)
        // Building::all()->each(function ($building) {
        //     $building->classrooms()->saveMany(
        //         \App\Models\Classroom::factory(rand(2, 5))->make()
        //     );
        // });
    }
}