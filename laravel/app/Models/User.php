<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'initial_balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'initial_balance' => 'float',
    ];

    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    protected function activ() : Attribute{
        return Attribute::make(
            get: function(){
                return $this->attributes['active'] ? '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-warning">Inactivo</span>';
            }
        );
    }

    protected function imagen() : Attribute{
        return Attribute::make(
            get: function(){
                return $this->image ? Storage::url('public/'.$this->image->url): asset('no-image.png');
            }
        );
    }

    // relaciones 

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function ajuste(){
        return $this->hasOne(ajuste::class, 'user_id');
    }


    public function cortesCaja(){
        return $this->hasMany(corte_caja::class);
    }

    public function corteCajaActual()
    {
        return $this->cortesCaja()->whereNull('fecha_cierre')->first();
    }
}
