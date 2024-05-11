<?php

namespace App\Livewire\Sucursal;

use App\Models\Sucursal;
use Livewire\Component;

class SucursalShow extends Component
{
    public Sucursal $category;
    public function render()
    {
        return view('livewire.sucursal.sucursal-show');
    }
}
