<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Suscriptores extends Model
{
    use HasFactory;
    public function cliente(){
        return $this->belongsTo(Client::class);
    }

    public function suscripcion(){
        return $this->belongsTo(Suscrib::class);
    }

    protected function activ() : Attribute{
        return Attribute::make(
            get: function(){
                return $this->attributes['active'] ? '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-warning">Inactivo</span>';
            }
        );
    }
}
