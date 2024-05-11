<?php

namespace App\Livewire\Suscribs;

use App\Models\Suscrib;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detalle Suscripciones')]

class SuscribsShow extends Component
{
    public Suscrib $suscrib;
    public function render()
    {
        return view('livewire.suscribs.suscribs-show');
    }
}
