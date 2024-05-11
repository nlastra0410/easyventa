<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    use HasFactory;

    public function ajuste(){
        return $this->hasOne(ajuste::class, 'proveedor_id');
    }

    // public function productos(){
    //     return $this->hasMany(Product::class, 'proveedor_id');
    // }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
