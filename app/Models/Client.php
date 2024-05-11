<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public function suscriptores(){
        return $this->hasMany(Suscriptores::class);
    }

    // relaciones 

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function suscripcion()
{
    return $this->hasOne(suscripciones::class, 'rut_cliente', 'rut');
}
}
