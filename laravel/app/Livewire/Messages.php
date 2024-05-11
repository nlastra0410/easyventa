<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithEvents;

class Messages extends Component
{
    
    public function render()
    {
        return view('livewire.messages');
    }

    #[On('msg')]
    public function msgs($msg){
        session()->flash('msg', $msg);

    }

    #[On('scan-notfound')]
    public function scanNotfound($msg){
        session()->flash('scan-notfound', $msg);

    }

    #[On('no-stock')]
    public function noStock($msg){
        session()->flash('no-stock', $msg);

    }

}
