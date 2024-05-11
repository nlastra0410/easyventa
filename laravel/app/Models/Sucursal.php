<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    public function usuario(){
        return $this->hasMany(User::class);
    }

    public function store(){
        return $this->belongsTo(shop::class);
    }
}
