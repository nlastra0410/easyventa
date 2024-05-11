<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('EasyVenta/Categorias')]

class CategoryComponent extends Component
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

        $this->totalRegistros = Category::count();
        $categories =Category::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        //$categories = collect();
        return view('livewire.category.category-component', [
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
            'name'=> 'required|min:5|max:255|unique:categories'
        ];

        $messages = [
            'name.required' => 'El nombre de la categoria, es requerido',
            'name.min' => 'El nombre de la categoria debe de tener 5 caracteres',
            'name.max' => 'El nombre de la categoria no debe superar los 255 caracteres',
            'name.unique'=> 'El nombre de la categoria ya está en uso'
        ];
        $this->validate($rules,$messages);

        

        $category = new Category();
        $category->name = $this->name;
        $category->save();

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Categoria Creada con éxito');

    
        $this->reset(['name']);

        
    }

    public function edit(Category $category){
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->dispatch('open-modal','modalCategory');



        //dump($category);
    }
    #[On('destroyCategory')]
    public function destroy($id){
        //dump($id);
        $category = Category::findOrfail($id);
        $category->delete();

        $this->dispatch('msg','La Categoria se eliminó con éxito');
    }

    public function update(Category $category){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255|unique:categories,id,'.$this->Id
        ];

        $messages = [
            'name.required' => 'El nombre de la categoria, es requerido',
            'name.min' => 'El nombre de la categoria debe de tener 5 caracteres',
            'name.max' => 'El nombre de la categoria no debe superar los 255 caracteres',
        ];
        $this->validate($rules,$messages);

        $category->name = $this->name;
        $category->update();  

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Categoria Editada con éxito');

    
        $this->reset(['name']);
    }

    
}