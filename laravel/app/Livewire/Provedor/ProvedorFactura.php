<?php

namespace App\Livewire\Provedor;

use App\Models\ajuste;
use App\Models\Product;
use App\Models\proveedores;
use Livewire\Attributes\On;
use Livewire\Component;

class ProvedorFactura extends Component
{
    public $proveedor;
    public $SKU;
    public $rutProv;
    public $product;
    public $newStock;
    public $producto;
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
    public $habilitarEscritura;
    public $enfocarInputStock = false;

    public function mount(proveedores $proveedor)
    {
        $this->proveedor = $proveedor;
    }
    public function render()
    {
        return view('livewire.provedor.provedor-factura');
    }

    #[On('inventario-encontrado')]
    public function BuscaInventario()
    {
        // dd('producto escaneado');
        $this->product = Product::where('SKU', $this->SKU)->first();

        if (!$this->product) {

            $this->product = null;
            $this->reset(['product', 'SKU']);
            $this->dispatch('no-stock', 'producto no encontrado');
            return;
        } else {
            $this->costPrice = $this->product->precio_venta;
            $this->salePrice = $this->product->precio_compra;
            $this->salePL = $this->product->precio_farmaPL;
            $this->dispatch('msg', 'Producto encontrado');
            // Enfocar el input con id "stock"
            $this->enfocarInputStock = true;

        }



        $this->dispatch('reinitializeSelect2');
    }

    public function updateQuantity()
    {

        if ($this->product) {
            $this->product->stock += $this->newStock;
            $this->product->precio_venta = $this->costPrice;
            $this->product->precio_compra = $this->salePrice;
            $this->product->precio_farmaPL = $this->salePL;
            $this->product->proveedor_id = $this->proveedor->id;

            $this->product->proveedores()->attach($this->proveedor->id, ['quantity' => $this->newStock, 'precio' => $this->salePrice]);
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
            $ajuste->proveedor_id = $this->proveedor->id;
            $ajuste->precio = $this->salePrice;
            $ajuste->save();
        }




        // Limpiar los campos después de la actualización
        $this->SKU = '';
        $this->product = null;
        $this->newStock = '';
        $this->costPrice = '';
        $this->salePrice = '';
        $this->salePL = '';
        $this->rutProv = '';
        $this->pro = '';
        $this->dispatch('msg', 'Nuevo stock actualizado');
    }

    public function cancelSearch()
    {
        // Limpiar los datos del producto y el SKU
        $this->reset(['product', 'SKU']);
    }
}
