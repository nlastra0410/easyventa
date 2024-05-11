<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suscripciones extends Model
{
    use HasFactory;
    public function cliente()
    {
        return $this->belongsTo(Client::class, 'rut_cliente', 'rut');
    }
}
