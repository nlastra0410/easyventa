<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;

#[Title('Ver Producto')]

class ProductShow extends Component
{
    public Product $product;
    public function render()
    {

        // Agrupar los proveedores y sumar las cantidades correspondientes
        $proveedores = $this->product->proveedores->groupBy('id')->map(function ($proveedores) {
            $proveedor = $proveedores->first();
            $proveedor->quantity = $proveedores->sum(function ($proveedor) {
                return $proveedor->pivot->quantity;
            });
            return $proveedor;
        });
        return view('livewire.product.product-show', compact('proveedores'));
    }
}
