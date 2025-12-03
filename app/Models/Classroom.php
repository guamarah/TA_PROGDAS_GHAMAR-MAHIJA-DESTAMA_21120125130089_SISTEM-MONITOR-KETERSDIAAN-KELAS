<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'code', 
        'capacity', 
        'description', 
        'building_id' // Harus disertakan sebagai foreign key
    ];

    /**
     * Relasi Belongs To: Kelas ini dimiliki oleh satu Gedung.
     * Foreign Key: 'building_id' di tabel ini.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Relasi One-to-Many: Satu Kelas memiliki banyak Jadwal.
     * Foreign Key: 'classroom_id' di tabel 'schedules'.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}