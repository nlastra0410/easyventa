<?php

namespace App\Livewire\Tienda;

use App\Models\shop;
use Livewire\Component;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatosTienda extends Component
{
    public function render()
    {
        $store = shop::find(1);
        return view('livewire.tienda.datos-tienda', compact('store'));;
    }

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $sucursal = $user->sucursal; // Obtener la sucursal del usuario

        // Verificar si la sucursal del usuario está asociada a una tienda
        if ($sucursal && $sucursal->store) {
            // Filtrar los datos de la tienda basándose en la sucursal del usuario
            $request->merge(['store' => $sucursal->store]);
            return $next($request);
        }

        

        // Si el usuario no tiene asociada una sucursal o la sucursal no tiene tienda asociada, redirigir o manejar el error
        // Puedes personalizar esta lógica según tus necesidades

        return redirect('/home');
    }
}
