<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            
            // Kolom Relasi (Wajib)
            // Pastikan tabel 'buildings' sudah dibuat sebelum migration ini dijalankan
            $table->foreignId('building_id')->constrained()->cascadeOnDelete(); 
        

            // Kolom Identitas & Detail
            $table->string('name');
            $table->string('code'); // Tambahkan unique agar kode kelas tidak ganda
            $table->integer('capacity');
            $table->string('description')->nullable();
            
            // Kolom Status (Sesuai yang Anda berikan, menggunakan enum)
            $table->enum('status', ['available', 'in_use', 'maintenance'])->default('available');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};