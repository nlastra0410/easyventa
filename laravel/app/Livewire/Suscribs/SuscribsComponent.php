<?php

namespace App\Livewire\Suscribs;

use App\Models\Suscrib;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('EasyVenta/Suscripciones')]

class SuscribsComponent extends Component
{
    use WithPagination;

    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    
    public $Id;
    public $name;
    public $codigo;
    public $meses;
    public $costo;
    public $active;

    public function render()
    {
        if($this->search!=''){
            $this->resetPage();
        }

        $this->totalRegistros = Suscrib::count();
        $suscrib =Suscrib::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        //$categories = collect();
        return view('livewire.suscribs.suscribs-component', [
            'suscrib' => $suscrib
        ]);
    }

    public function create(){

        $this->Id=0;
        
        $this->clean();
        $this->dispatch('open-modal','modalSuscrib');
    }

    public function store(){
        //dump('Crear producto');
        $rules = [
            'name'=> 'required|min:5|max:255',
            'codigo'=> 'required|min:5|max:255|unique:suscrib'
        ];
        $this->validate($rules);
        $suscrib = new Suscrib();
        
        $suscrib->name = $this->name;
        $suscrib->codigo = $this->codigo;
        $suscrib->meses = $this->meses;
        $suscrib->costo = $this->costo;
        $suscrib->active = $this->active;
        $suscrib->save();

        $this->dispatch('close-modal','modalSuscrib');
        $this->dispatch('msg','Suscripción Creada con éxito');
        $this->clean();


        
    }

    public function edit(Suscrib $suscrib){
        $this->clean();
        $this->Id = $suscrib->id;
        $this->name = $suscrib->name;
        $this->codigo = $suscrib->codigo;
        $this->meses = $suscrib->meses;
        $this->costo = $suscrib->costo;
        $this->active = $suscrib->active;


        $this->dispatch('open-modal','modalSuscrib');



        //dump($category);
    }

    public function update(Suscrib $suscrib){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255',
            'codigo'=> 'required|min:5|max:255'
        ];
        $this->validate($rules);

        $suscrib->name = $this->name;
        $suscrib->codigo = $this->codigo;
        $suscrib->meses = $this->meses;
        $suscrib->costo = $this->costo;
        $suscrib->active = $this->active;

        //$product->image = $this->imageModel;

        $suscrib->update();  

        $this->dispatch('close-modal','modalSuscrib');
        $this->dispatch('msg','Suscripción Editada con éxito');

    
        $this->clean();
    }
    public function clean(){

        $this->reset(['Id','name','codigo','meses','costo','active']);
        $this->resetErrorBag();
    }
}
