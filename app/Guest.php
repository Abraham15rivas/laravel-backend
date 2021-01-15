<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests';
    protected $fillable = [
       'name', 'last_name', 'ci', 'age', 'number_phone', 'address', 'user_id'
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations ()
    {
        return $this->hasMany(Reservation::class);
    }
}
