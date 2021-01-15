<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'code', 'number_floor', 'number_room', 'status', 'room_type_id'
    ];

    public function roomsReservations ()
    {
        return $this->belongsToMany(Reservation::class)->withTimestamps();
    }

    public function roomType ()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function hotel ()
    {
        return $this->belongsTo(Hotel::class);
    }
}
