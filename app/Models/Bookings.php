<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bookings extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';
    
    protected $fillable = [
        'user_id',
        'class_id',
        'booking_time',
    ];

    protected $casts = [
        'booking_time' => 'datetime',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the jadwal kelas associated with the booking.
     */
    public function jadwalKelas()
    {
        return $this->belongsTo(JadwalKelas::class, 'class_id', 'class_id');
    }

    /**
     * Get human readable time difference.
     */
    public function getBookingTimeHumanAttribute()
    {
        return $this->booking_time ? Carbon::parse($this->booking_time)->diffForHumans() : null;
    }

    /**
     * Get human readable created at time.
     */
    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : null;
    }
}
