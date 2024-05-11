<?php

namespace App\Livewire\Principio;

use Livewire\Component;
use App\Models\Principio;

class PrincipioShow extends Component
{
    public Principio $category;
    public function render()
    {
        return view('livewire.principio.principio-show');
    }
}