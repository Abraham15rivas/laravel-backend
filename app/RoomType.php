<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'room_types';
    protected $fillable = [
        'titulo', 'price_day', 'description'
    ];

    public function rooms ()
    {
        return $this->hasMany(Room::class);
    }
}
