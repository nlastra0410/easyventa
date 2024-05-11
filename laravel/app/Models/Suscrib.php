<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Suscrib extends Model
{
    use HasFactory;

    public function suscriptores(){
        return $this->hasMany(Suscriptores::class);
    }

    protected function activ() : Attribute{
        return Attribute::make(
            get: function(){
                return $this->attributes['active'] ? '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-warning">Inactivo</span>';
            }
        );
    }

    protected function precio() : Attribute{
        return Attribute::make(
            get: function(){
                return '<b>$'.number_format($this->attributes['costo'],0,',','.').'</b>';
            }
        );
    }
}
