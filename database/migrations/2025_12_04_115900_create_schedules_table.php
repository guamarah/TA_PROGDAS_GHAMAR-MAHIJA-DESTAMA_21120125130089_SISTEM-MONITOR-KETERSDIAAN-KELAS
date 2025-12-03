<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('schedules', function (Blueprint $table) {
        // 1. Primary Key
        $table->id();

        // 2. Foreign Keys (Wajib untuk menghubungkan)
        $table->foreignId('building_id')->constrained()->cascadeOnDelete();
        $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
        $table->foreignId('classroom_id')->constrained()->cascadeOnDelete(); // Kelas mana yang dijadwalkan
    



        // 3. Detail Waktu (Inti dari tabel Schedule)
        $table->string('day_of_week'); // Contoh: 'Monday', 'Tuesday', atau 'Senin', 'Selasa'
        $table->time('start_time'); // Contoh: 07:00:00
        $table->time('end_time'); // Contoh: 08:30:00

        // 4. Pengaturan Tambahan (Opsional)
     
        $table->string('status')->default('scheduled'); // Contoh: 'scheduled', 'cancelled', 'completed'
        $table->text('notes')->nullable(); 

        // 5. Constraints/Indeks
        // Penting untuk memastikan satu kelas/guru/subjek tidak dijadwalkan pada jam dan hari yang sama
        $table->unique(['classroom_id', 'day_of_week', 'start_time']);

        // 6. Standar Laravel
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
