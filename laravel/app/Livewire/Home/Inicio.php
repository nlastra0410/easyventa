<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('EasyVenta/Ventas')]

class Inicio extends Component
{
    use WithPagination;
    public function render()
    {

        return view('livewire.home.inicio');
    }

}
