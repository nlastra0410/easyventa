<?php

namespace App\Livewire\Inventario;

use App\Models\ajuste;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class MovimientoComponent extends Component
{
    use WithPagination;
    public ajuste $moves;
    public $search = '';
    public $selectedType = '';
    public $startDate;
    public $endDate;
    public $cant=10;
    
    public function render()
    {
        
        $movimientos = ajuste::where(function ($query) {
            // Condición de búsqueda por motivo o nombre de producto
            $query->where('motivo', 'like', '%'.$this->search.'%')
                ->orWhereHas('product', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('product', function ($query) {
                    $query->where('SKU', 'like', '%'.$this->search.'%');
                });
        })
        ->when($this->selectedType, function ($query, $type) {
            // Condición de búsqueda por tipo de movimiento
            return $query->where('type', $type);
        })
        ->when($this->startDate && $this->endDate, function ($query) {
            // Condición de búsqueda por rango de fecha
            return $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ]);
        })
        ->orderByDesc('id','desc')
        ->paginate($this->cant);
        return view('livewire.inventario.movimiento-component',[
            'movimientos' => $movimientos
        ]);
    }
}
