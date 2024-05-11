<?php

namespace App\Livewire\User;

use App\Models\Sucursal;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('EasyVenta/Usuarios')]

class UserComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    public $Id;
    public $name;
    public $email;  
    public $password;   
    public $admin;
    public $active = true;
    public $sucursal_id;
    public $image;
    public $imageModel;
    public $re_password;

    public function render()
    {
        
        $this->totalRegistros = User::count();
        $users =User::where('name','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.user.user-component', [
            'users' => $users
        ]);
    }

    #[computed()]
    public function Sucursal(){
        return Sucursal::all();
    }

    public function create(){

        $this->Id=0;
        
        $this->clean(); 
        
        $this->dispatch('open-modal','modalUser');
    }

    public function store(){
        //dump('Crear producto');
        $rules = [
            'name'=> 'required|min:5|max:255',
            'email'=> 'required|email|max:255|unique:users',
            'password'=> 'required|min:5',
            're_password'=> 'required|same:password',
            'image'=> 'image|max:1024|nullable'
            
        ];
        $this->validate($rules);


        $user = new User();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);  
        $user->admin = $this->admin;
        $user->active = $this->active;
        $user->sucursal_id = $this->sucursal_id;
        $user->save();

        if($this->image){
            $customName = 'users/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public',$customName);
            $user->image()->create(['url'=>$customName]);
        }

        $this->dispatch('close-modal','modalUser');
        $this->dispatch('msg','El usuario fue Creado con éxito');
        $this->clean();


        
    }

    public function edit(User $user){

        $this->clean();

        $this->Id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->admin = $user->admin ? true : false;
        $this->active = $user->active ? true : false;
        $this->sucursal_id = $user->sucursal_id;
        $this->imageModel = $user->image ? $user->image->url : null;


        $this->dispatch('open-modal','modalUser');



        //dump($category);
    }

    public function update(User $user){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255',
            'email'=> 'required|email|max:255|unique:users,id,'.$this->Id,
            'password'=> 'min:5|nullable',
            're_password'=> 'same:password|nullable',
            'image'=> 'image|max:1024|nullable'
        ];

        $this->validate($rules);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->admin = $this->admin;
        $user->active = $this->active;
        $user->sucursal_id = $this->sucursal_id;

        if($this->password){
            $user->password = $this->password;
        }

        $user->update();  
        if($this->image){
            if($user->image!=null){
                Storage::delete('public/'. $user->image->url);
                $user->image()->delete();    
            }
            $customName = 'users/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public',$customName);
            $user->image()->create(['url'=>$customName]);
        }

        $this->dispatch('close-modal','modalUser');
        $this->dispatch('msg','Usuario Editado con éxito');

    
        $this->clean();
    }

    #[On('destroyUser')]
    public function destroy($id){
        //dump($id);
        $user = User::findOrfail($id);

        if($user->image!=null){
            Storage::delete('public/'. $user->image->url);
            $user->image()->delete();    
        }

        $user->delete();

        $this->dispatch('msg','El usuario se eliminó con éxito');
    }

    public function clean(){

        $this->reset(['Id','name','image','email','password','admin','active','sucursal_id','imageModel']);
        $this->resetErrorBag();
    }
}
