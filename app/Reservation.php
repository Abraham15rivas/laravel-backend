<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $fillable = [
        'start_date', 'finish_date', 'amount_room', 'total_price', 'status', 'guest_id'
    ];
    
    public function guest ()
    {
        return $this->belongsTo(Guest::class);
    }

    public function reservationsRooms ()
    {
        return $this->belongsToMany(Room::class)->withTimestamps();
    }
}
