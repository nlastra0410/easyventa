<?php

namespace App\Livewire\Provedor;

use App\Models\Product;
use App\Models\proveedores;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\WithPagination;



class ProvedorShow extends Component
{
    use WithPagination;
    public $proveedor;
    public $search='';

    public function mount(proveedores $proveedor)
    {
        $this->proveedor = $proveedor;
    }
    
    public function render()
    {
        $productos = $this->proveedor->products()
            ->when($this->search, function ($query) {
                return $query->where('SKU', 'like', '%'.$this->search.'%');
            })
            ->get();
        
        return view('livewire.provedor.provedor-show', compact('productos'));
    }
}
