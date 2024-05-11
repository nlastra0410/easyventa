<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Title('EasyVenta/Clientes')]

class ClientComponent extends Component
{

    use WithPagination;

    //Propiedades clase
    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    //Propiedades Modelo

    
    public $Id;
    public $name;
    public $rut;
    public $telefono;
    public $email;
    public $password;
    public $re_password;

    public function render()
    {
        if($this->search!=''){
            $this->resetPage();
        }

        $this->totalRegistros = Client::count();
        $clientes =Client::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.client.client-component', [
            'clientes' => $clientes
        ]);
    }

    public function create(){

        $this->Id=0;
        $this->clean(); 
        $this->dispatch('open-modal','modalClient');
    }

    public function store(){
        //dump('Crear Categoria');
        $rules = [
            'name'=> 'required|min:5|max:255',
            'rut'=> 'required|min:8|max:9|unique:clients',
            'telefono'=> 'min:9|numeric',
            're_password'=> 'same:password',
        ];
        $this->validate($rules);

        

        $clientes = new Client();
        $clientes->name = $this->name;
        $clientes->rut = $this->rut;
        $clientes->telefono = $this->telefono;
        $clientes->email = $this->email;    
        $clientes->password = $this->password;  

        $clientes->save();

        $this->dispatch('close-modal','modalClient');
        $this->dispatch('msg','Cliente añadido con éxito');

    
        $this->clean();

        
    }

    public function edit(Client $clientes){
        $this->Id = $clientes->id;
        $this->name = $clientes->name;
        $this->rut = $clientes->rut;
        $this->telefono = $clientes->telefono;
        $this->email = $clientes->email;
        $this->dispatch('open-modal','modalClient');



        //dump($category);
    }

    public function update(Client $clientes){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255',
            'rut'=> 'required|min:8|max:9|unique:clients,id,'.$this->Id,
            'telefono'=> 'min:9|numeric',
            're_password'=> 'same:password',
        ];
        $this->validate($rules);

        $clientes->name = $this->name;
        $clientes->rut = $this->rut;
        $clientes->telefono = $this->telefono;
        $clientes->email = $this->email;

        if($this->password){
            $clientes->password = $this->password;
        }

        $clientes->update();  

        $this->dispatch('close-modal','modalClient');
        $this->dispatch('msg','Cliente Editado con éxito');

    
        $this->clean();
    }


    #[On('destroyClient')]
    public function destroy($Id){
        //dump($id);
        $clientes = Client::findOrfail($Id);
        $clientes->delete();

        $this->dispatch('msg','El cliente fue eliminado con éxito');
    }

    public function clean(){

        $this->reset(['Id','name','rut','telefono','email','password']);
        $this->resetErrorBag();
    }
}
