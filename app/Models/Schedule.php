<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'classroom_id', // Foreign Key
        'teacher_id',   // Foreign Key
        'building_id', // Foreign Key
        'code_id', // Foreign Key
        'day_of_week', 
        'start_time', 
        'end_time',
       
        'status', 
        'notes'
    ];

    /**
     * Relasi Belongs To: Jadwal ini dimiliki oleh satu Kelas.
     * Foreign Key: 'classroom_id' di tabel ini.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    
    /**
     * Relasi Belongs To: Jadwal ini dimiliki oleh satu Guru.
     * Menggunakan Model User, dengan Foreign Key: 'teacher_id'.
     */
 

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function teacher()
{
    return $this->belongsTo(Teacher::class);
}
public function code()
{
    return $this->belongsTo(Code::class);
}

}