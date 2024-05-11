<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cash_closures extends Model
{
    use HasFactory;
    
    public function transactions(){
        return $this->hasMany(transactions::class);
    }

    public function branch(){
        return $this->belongsTo(Sucursal::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
