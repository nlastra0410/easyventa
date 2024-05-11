<?php

namespace App\Livewire\Enfermedad;

use Livewire\Component;
use App\Models\Enfermedad;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class EnfermedadComponent extends Component
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

        $this->totalRegistros = Enfermedad::count();
        $categories =Enfermedad::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        //$categories = collect();
        return view('livewire.enfermedad.enfermedad-component', [
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
            'name.required' => 'El nombre para la enfermedad, es requerido',
            'name.min' => 'El nombre para la enfermedad debe de tener 5 caracteres',
            'name.max' => 'El nombre para la enfermedad no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        

        $category = new Enfermedad();
        $category->name = $this->name;
        $category->save();

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Enfermedad Registrada con éxito');

    
        $this->reset(['name']);

        
    }

    public function edit(Enfermedad $category){
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->dispatch('open-modal','modalCategory');



        //dump($category);
    }

    public function update(Enfermedad $category){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255'
        ];

        $messages = [
            'name.required' => 'El nombre para la enfermedad, es requerido',
            'name.min' => 'El nombre para la enfermedad debe de tener 5 caracteres',
            'name.max' => 'El nombre para la enfermedad no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        $category->name = $this->name;
        $category->update();  

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Enfermedad Editada con éxito');

    
        $this->reset(['name']);
    }

    #[On('destroyCategory')]
    public function destroy($id){
        //dump($id);
        $category = Enfermedad::findOrfail($id);
        $category->delete();

        $this->dispatch('msg','La enfermedad se eliminó con éxito');
    }
}