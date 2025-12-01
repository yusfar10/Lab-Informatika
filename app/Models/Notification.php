<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id',
        'pesan',
        'notification_time',
        'is_read',
        'type',
    ];

    protected $casts = [
        'notification_time' => 'datetime',
        'is_read' => 'boolean',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the booking associated with the notification (optional).
     */
    public function booking()
    {
        return $this->belongsTo(Bookings::class, 'related_id', 'booking_id');
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope for filtering by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get human readable notification time.
     */
    public function getNotificationTimeHumanAttribute()
    {
        return $this->notification_time ? Carbon::parse($this->notification_time)->diffForHumans() : null;
    }
}
