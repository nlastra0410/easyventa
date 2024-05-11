<?php

namespace App\Livewire\Sucursal;

use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class SucursalComponent extends Component
{
    use WithPagination;

    //Propiedades clase
    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    //Propiedades Modelo

    public $name;
    public $Id;
    public function render()
    {

        if($this->search!=''){
            $this->resetPage();
        }

        $this->totalRegistros = Sucursal::count();
        $categories = Sucursal::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.sucursal.sucursal-component', [
            'categories' => $categories
        ]);
    }

    public function create(){

        $this->Id=0;
        
        $this->reset(['name']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalCategory');
    }

    public function store(){
        //dump('Crear Categoria');
        $rules = [
            'name'=> 'required|min:5|max:255'
        ];

        $messages = [
            'name.required' => 'El nombre de la sucursal, es requerido',
            'name.min' => 'El nombre de la sucursal debe de tener 5 caracteres',
            'name.max' => 'El nombre de la sucursal no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        

        $category = new Sucursal();
        $category->name = $this->name;
        $category->save();

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Sucursal Registrada con éxito');

    
        $this->reset(['name']);

        
    }

    public function edit(Sucursal $category){
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->dispatch('open-modal','modalCategory');



        //dump($category);
    }

    public function update(Sucursal $category){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255'
        ];

        $messages = [
            'name.required' => 'El nombre la sucursal, es requerido',
            'name.min' => 'El nombre la sucursal debe de tener 5 caracteres',
            'name.max' => 'El nombre la sucursal no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        $category->name = $this->name;
        $category->update();  

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Sucursal Editada con éxito');

    
        $this->reset(['name']);
    }

    #[On('destroyCategory')]
    public function destroy($Id){
        //dump($id);
        $category = Sucursal::findOrfail($Id);
        $category->delete();

        $this->dispatch('msg','La Sucursal se eliminó con éxito');
    }
}
