<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'name', 
        'address', 
        'floors', 
        'description', 
        'is_active'
    ];

    /**
     * Relasi One-to-Many: Satu Gedung memiliki banyak Kelas.
     * Foreign Key: 'building_id' di tabel 'classrooms'.
     */
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}