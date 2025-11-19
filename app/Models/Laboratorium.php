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
}
