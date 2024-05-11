<?php

namespace App\Livewire\Enfermedad;

use App\Models\Enfermedad;
use Livewire\Component;

class EnfermedadShow extends Component
{
    public Enfermedad $category;
    public function render()
    {
        return view('livewire.enfermedad.enfermedad-show');
    }
}