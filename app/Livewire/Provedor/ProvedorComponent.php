<?php

namespace App\Livewire\Provedor;

use App\Models\proveedores;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class ProvedorComponent extends Component
{
    use WithPagination;

    //Propiedades clase
    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    //Propiedades Modelo
    public $name;
    public $Id;
    public $email;
    public $telefono;
    public $direccion;
    public $info_contacto;
    public $nota;
    public $rut;
    public $proveedor;
    public function render()
    {
        if($this->search!=''){
            $this->resetPage();
        }

        $this->totalRegistros = proveedores::count();
        $proveedores =proveedores::where('nombre','like','%'.$this->search.'%')
                    ->orWhere('rut','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.provedor.provedor-component',[
            'proveedores' => $proveedores
        ]);
    }

    public function create(){

        $this->Id=0;
        $this->clean();
        $this->dispatch('open-modal','modalProveedor');
    }

    public function store(){
        //dump('Crear Categoria');
        $rules = [
            'name'=> 'required|min:5|max:255|unique:proveedores',
            'rut'=> 'required|min:8|max:10|unique:proveedores',
            'telefono'=> 'required|min:9|numeric',
        ];
        $this->validate($rules);

        

        $proveedor = new proveedores();
        $proveedor->nombre = $this->name;
        $proveedor->email = $this->email;
        $proveedor->telefono = $this->telefono;
        $proveedor->direccion = $this->direccion;
        $proveedor->info_contacto = $this->info_contacto;
        $proveedor->nota = $this->nota;
        $proveedor->rut = $this->rut;
        $proveedor->save();

        $this->dispatch('close-modal','modalProveedor');
        $this->dispatch('msg','Proveedor agregado con exito');

        $this->clean();
    }

    public function edit(proveedores $proveedor){
        $this->Id = $proveedor->id;
        $this->name = $proveedor->nombre;
        $this->email = $proveedor->email;
        $this->telefono = $proveedor->telefono;
        $this->direccion = $proveedor->direccion;
        $this->info_contacto = $proveedor->info_contacto;
        $this->nota = $proveedor->nota;
        $this->rut = $proveedor->rut;
        $this->dispatch('open-modal','modalProveedor');

        



        //dump($category);
    }

    public function update(proveedores $proveedor){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255|unique:proveedores,id,'.$this->Id,
            'rut'=> 'required|min:8|max:10|unique:proveedores,id'.$this->Id,
            'telefono'=> 'required|min:9|numeric',
        ];
        $this->validate($rules);

        $proveedor->nombre = $this->name;
        $proveedor->email = $this->email;
        $proveedor->telefono = $this->telefono;
        $proveedor->direccion = $this->direccion;
        $proveedor->info_contacto = $this->info_contacto;
        $proveedor->nota = $this->nota;
        $proveedor->rut = $this->rut;
        $proveedor->update();  

        $this->dispatch('close-modal','modalProveedor');
        $this->dispatch('msg','El proveedor fue editado de manera correcta');

    
        $this->clean();
    }

    public function clean(){

        $this->reset(['Id','name','rut','telefono','email','info_contacto','direccion','nota']);
        $this->resetErrorBag();
    }
}
