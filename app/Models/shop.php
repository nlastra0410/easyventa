<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop extends Model
{
    use HasFactory;
    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function sucursales(){
        return $this->hasMany(Sucursal::class);
    }
}
