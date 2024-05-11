<?php

namespace App\Livewire\Inventario;

use App\Models\ajuste;
use App\Models\product_proveedor;
use App\Models\proveedores;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InventarioComponent extends Component
{

    public $SKU;
    public $rutProv;
    public $product;
    public $newStock;
    public $costPrice;
    public $salePrice;
    public $salePL;
    public $provee = 1;
    public $nameProvee;
    public $pro;
    public $namePro;
    public $Id;

    //Propiedades Modelo
    public $name;
    public $email;
    public $telefono;
    public $direccion;
    public $info_contacto;
    public $nota;
    public $rut;
    public function render()
    {

        return view('livewire.inventario.inventario-component', [
            'prove' => proveedores::all()
        ]);
    }

    #[On('provee_id')]
    public function provee_id($id = 1)
    {
        $this->provee = $id;
        $this->nameProvee($id);
    }

    public function mount()
    {
        $this->nameProvee();
    }

    public function nameProvee($id = 1)
    {
        $findProvee = proveedores::find($id);
        $this->nameProvee = $findProvee->nombre;
    }

    public function BuscaProvee()
    {

        $this->pro = proveedores::where('rut', $this->rutProv)->first();

        if ($this->pro === null) {
            $this->Id = 0;
            $this->clean();
            $this->dispatch('open-modal', 'modalProveedor');
        }



    }

    public function store()
    {
        //dump('Crear Categoria');
        $rules = [
            'name' => 'required|min:5|max:255|unique:proveedores',
            'rut' => 'required|min:8|max:10|unique:proveedores',
            'telefono' => 'required|min:9|numeric',
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


        $this->dispatch('close-modal', 'modalProveedor');
        $this->dispatch('msg', 'Proveedor agregado con exito');

        $this->clean();
    }

    public function clean()
    {

        $this->reset(['Id', 'name', 'rut', 'telefono', 'email', 'info_contacto', 'direccion', 'nota']);
        $this->resetErrorBag();
    }

    public function BuscaInventario()
    {
        // dd('producto escaneado');
        $this->product = Product::where('SKU', $this->SKU)->first();

        if(!$this->product){
            
            $this->product = null;
            $this->reset(['product', 'SKU']);
            $this->dispatch('no-stock', 'producto no encontrado');
            return;   
        }else{
            $this->costPrice = $this->product->precio_venta;
            $this->salePrice = $this->product->precio_compra;
            $this->salePL = $this->product->precio_farmaPL;
            $this->dispatch('msg', 'Producto encontrado');
        }

        

        $this->dispatch('reinitializeSelect2');
    }

    public function cancelSearch()
    {
        // Limpiar los datos del producto y el SKU
        $this->reset(['product', 'SKU']);
    }

    public function updateQuantity()
    {
        
        $this->product->stock += $this->newStock;
        $this->product->precio_venta = $this->costPrice;
        $this->product->precio_compra = $this->salePrice;
        $this->product->precio_farmaPL = $this->salePL;
        if($this->pro === null){
            $this->dispatch('open-modal', 'modalProveedor');
        }else{
            $this->product->proveedor_id = $this->pro->id;
        }

        $this->product->proveedores()->attach($this->pro->id,['quantity' => $this->newStock]);
        // $this->product->proveedor_id = $this->pro->id;
        $this->product->save();

        $ajuste = new ajuste();
        $ajuste->motivo = 'Recepción de inventario';
        $ajuste->product_id = $this->product->id;
        $ajuste->user_id = userID();
        $ajuste->stockV = $this->product->stock - $this->newStock;
        $ajuste->stockA = $this->product->stock;
        $ajuste->type = 'Entrada';
        $ajuste->cantidad = $this->newStock;
        if($this->pro === null){
            $this->dispatch('open-modal', 'modalProveedor');
            return;
        }else{
            $this->product->proveedor_id = $this->pro->id;
        }
        $ajuste->save();

        

        // Limpiar los campos después de la actualización
        $this->SKU = '';
        $this->product = null;
        $this->newStock = '';
        $this->costPrice = '';
        $this->salePrice = '';
        $this->salePL = '';
        $this->rutProv ='';
        $this->pro = '';
        $this->dispatch('msg', 'Nuevo stock actualizado');
    }
}


