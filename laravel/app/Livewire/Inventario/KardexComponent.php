<?php

namespace App\Livewire\Inventario;

use App\Models\Product;
use Livewire\Component;

class KardexComponent extends Component
{
    public $SKU;
    public $product;
    public $adjustments;
    public function render()
    {
        return view('livewire.inventario.kardex-component');
    }

    public function buscarProducto()
    {
        $this->reset(['product', 'adjustments']);

        if (!empty($this->SKU)) {
            $this->validate([
                'SKU' => 'required|string|max:255',
            ]);

            $this->product = Product::where('SKU', $this->SKU)->first();

            if ($this->product) {
                // Cargar ajustes asociados al producto
                $this->adjustments = $this->product->ajuste()->orderBy('fecha')->get();
            }
        }
    }
}
