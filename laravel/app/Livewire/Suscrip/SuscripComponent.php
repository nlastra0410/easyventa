<?php

namespace App\Livewire\Suscrip;

use App\Models\Client;
use App\Models\Suscrib;
use App\Models\Suscriptores;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;

#[Title('EasyVenta/Suscriptores')]

class SuscripComponent extends Component
{


    #[computed()]
    public function cliente(){
        return Client::all();
    }

    #[computed()]
    public function suscribs(){
        return Suscrib::all();
    }
    use WithPagination;
    use WithFileUploads;
    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    public $Id;
    public $client_id;
    public $suscrib_id;
    public $active;
    public $inicio;
    public $fin;

    public function render()
    {
        $this->totalRegistros = Suscriptores::count();
        $suscrip =Suscriptores::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.suscrip.suscrip-component', [
            'suscrip' => $suscrip
        ]);
    }

    public function create(){

        $this->Id=0;
        
        $this->clean(); 
        
        $this->dispatch('open-modal','modalSuscrip');
    }

    public function store(){
        //dump('Crear producto');
        $rules = [
            'client_id'=> 'required',
            'suscrib_id'=> 'required',
            'inicio'=> 'required',
            'fin'=> 'required'
            
        ];
        $this->validate($rules);


        $suscrip = new Suscriptores();

        $suscrip->client_id = $this->client_id;
        $suscrip->suscrib_id = $this->suscrib_id;
        $suscrip->inicio = $this->inicio;
        $suscrip->fin = $this->fin;
        $suscrip->save();

        $this->dispatch('close-modal','modalSuscrip');
        $this->dispatch('msg','Se generó la suscripción exitosamente');
        $this->clean();


        
    }

    public function clean(){

        $this->reset(['Id','client_id','suscrib_id','active','inicio','fin']);
        $this->resetErrorBag();
    }
}
