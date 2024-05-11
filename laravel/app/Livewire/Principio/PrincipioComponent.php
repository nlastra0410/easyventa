<?php

namespace App\Livewire\Principio;

use App\Models\Principio;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PrincipioComponent extends Component
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

        $this->totalRegistros = Principio::count();
        $categories =Principio::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        //$categories = collect();
        return view('livewire.principio.principio-component', [
            'categories' => $categories
        ]);
        
    }

    public function mount(){
        
    }

    public function create(){

        $this->Id=0;
        
        $this->reset(['name']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalCategory');
    }

    //Crear Categoria
    public function store(){
        //dump('Crear Categoria');
        $rules = [
            'name'=> 'required|min:5|max:255'
        ];

        $messages = [
            'name.required' => 'El nombre del Principio activo es requerido',
            'name.min' => 'El nombre del Principio activo debe de tener 5 caracteres',
            'name.max' => 'El nombre del Principio activo no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        

        $category = new Principio();
        $category->name = $this->name;
        $category->save();

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Principio Activo Creado con éxito');

    
        $this->reset(['name']);

        
    }

    public function edit(Principio $category){
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->dispatch('open-modal','modalCategory');



        //dump($category);
    }

    public function update(Principio $category){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255'
        ];

        $messages = [
            'name.required' => 'El nombre del Principio activo, es requerido',
            'name.min' => 'El nombre del Principio activo debe de tener 5 caracteres',
            'name.max' => 'El nombre del Principio activo no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        $category->name = $this->name;
        $category->update();  

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Principio Activo Editado con éxito');

    
        $this->reset(['name']);
    }

    #[On('destroyCategory')]
    public function destroy($id){
        //dump($id);
        $category = Principio::findOrfail($id);
        $category->delete();

        $this->dispatch('msg','El Principio Activo se eliminó con éxito');
    }
}