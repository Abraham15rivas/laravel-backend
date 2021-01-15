<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'role';
    protected $fillable = [
        'name', 'description'
    ];

    public function users ()
    {
        return $this->hasMany(User::class);
    }
}
