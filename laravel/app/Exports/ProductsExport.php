<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $productos;

    public function __construct($productos)
    {
        $this->productos = $productos;
    }

    public function collection()
    {
        return $this->productos;
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Producto',
            'Costo',
            'Precio Venta',
            'Existencia',
            'Stock mínimo',
        ];
    }
}
