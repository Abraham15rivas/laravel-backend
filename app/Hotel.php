<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';
    protected $fillable = [
        'name', 'number_floor', 'number_room', 'address'
    ];

    public function rooms ()
    {
        return $this->hasMany(Room::class);
    }
}
