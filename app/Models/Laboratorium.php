<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    protected $table = 'laboratorium';
    protected $primaryKey = 'room_id';
    protected $fillable = [
        'room_name',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Get the jadwal kelas for the laboratorium.
     */
    public function jadwalKelas()
    {
        return $this->hasMany(JadwalKelas::class, 'room_id', 'room_id');
    }

    /**
     * Get bookings through jadwal kelas.
     */
    public function bookings()
    {
        return $this->hasManyThrough(
            Bookings::class,
            JadwalKelas::class,
            'room_id', // Foreign key on jadwal_kelas table
            'class_id', // Foreign key on bookings table
            'room_id', // Local key on laboratorium table
            'class_id' // Local key on jadwal_kelas table
        );
    }
}
