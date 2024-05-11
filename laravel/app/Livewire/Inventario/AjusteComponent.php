<?php

namespace App\Livewire\Inventario;

use App\Models\ajuste;
use Livewire\Component;
use App\Models\Product;

class AjusteComponent extends Component
{
    public $SKU;
    public $product;
    public $newStock;
    public $costPrice;
    public $salePrice;
    public $salePL;
    public $difference;
    public $motivo;
    public $stock;

    public function render()
    {
        return view('livewire.inventario.ajuste-component');
    }

    public function BuscaInventario()
    {
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
            $this->stock = $this->product->stock;
            $this->newStock = $this->stock;
            $this->dispatch('msg', 'Producto encontrado');
        }

        
    }

    public function updatedNewStock($value)
    {
        $this->difference = intval($this->newStock) - intval($this->stock);
    }

    public function updatedDifference($value)
    {
        $this->newStock = intval($this->stock) + intval($this->difference);
    }


    public function updateQuantity()
    {
        $this->product->stock = $this->newStock;
        $this->product->precio_venta = $this->costPrice;
        $this->product->precio_compra = $this->salePrice;
        $this->product->precio_farmaPL = $this->salePL;
        $this->product->save();

        $ajuste = new Ajuste();
        $ajuste->motivo = "Ajuste: " . $this->motivo;
        $ajuste->product_id = $this->product->id;
        $ajuste->stockV = $this->product->stock - $this->difference;
        $ajuste->stockA = $this->product->stock;
        $ajuste->type = 'Ajuste';
        $ajuste->cantidad = $this->difference;
        $ajuste->user_id = userID();
        $ajuste->save();

        // Limpiar los campos después de la actualización
        $this->SKU = '';
        $this->product = null;
        $this->newStock = '';
        $this->costPrice = '';
        $this->salePrice = '';
        $this->salePL = '';
        $this->motivo = '';

        $this->dispatch('msg', 'Nuevo stock actualizado');
    }

    public function cancelSearch()
    {
        // Limpiar los datos del producto y el SKU
        $this->reset(['product', 'SKU']);
    }
}
