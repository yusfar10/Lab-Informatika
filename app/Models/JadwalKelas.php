<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'class_id';
    
    protected $fillable = [
        'class_name',
        'room_id',
        'penanggung_jawab',
        'start_time',
        'end_time',
        'status',
        'update_by',
        'semester',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the laboratorium associated with the jadwal kelas.
     */
    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class, 'room_id', 'room_id');
    }

    /**
     * Get the bookings for the jadwal kelas.
     */
    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'class_id', 'class_id');
    }

    /**
     * Get the user who updated the jadwal.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'update_by', 'id');
    }
}
