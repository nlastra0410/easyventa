<?php

namespace App\Livewire\Sale;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Currency extends Component
{
    #[Reactive]
    public $total;
    public $valores=[];
    public function render()
    {
        return view('livewire.sale.currency');
    }

    public function mount(){
        $this->valores=[
            500,1000,2000,5000,10000,20000
        ];
    }

    public function setPago($valor){
        $this->dispatch('setPago',$valor);
        $this->dispatch('close-modal','modalCurrency');
    }

    public function openModal(){
        $this->dispatch('open-modal','modalCurrency');
    }
}
