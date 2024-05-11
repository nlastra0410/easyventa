<?php

namespace App\Livewire\Inventario;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteComponent extends Component
{
    use WithPagination;
    public $search = '';
    public $cant=50;
    public function render()
    {
        $costoInventario = Product::sum('precio_compra');
        $cantidadTotalStock = Product::sum('stock');

        $sales =Product::where('name','like','%'.$this->search.'%')
        ->orwhere('SKU','like','%'.$this->search.'%')
        ->orWhereHas('category', function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate($this->cant);
        

        return view('livewire.inventario.reporte-component',[
            'costoInventario' => $costoInventario,
            'cantidadTotalStock' => $cantidadTotalStock,
            'sales' => $sales
        ]);
    }

    public function exportarExcel()
    {
        $productos =Product::where('name','like','%'.$this->search.'%')
        ->orwhere('SKU','like','%'.$this->search.'%')
        ->orWhereHas('category', function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%');
        })
        ->orderBy('id', 'desc')
        ->get();

        return Excel::download(new ProductsExport($productos), 'reporte_productos.xlsx');
    }
}
