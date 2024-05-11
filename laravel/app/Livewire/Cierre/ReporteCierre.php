<?php

namespace App\Livewire\Cierre;

use App\Models\corte_caja;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('EasyVenta/CierreTurno')]

class ReporteCierre extends Component
{
    public $cortesCaja;
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 10;
    public $startDate;
    public $endDate;
    public $usuario;
    public $corteSeleccionado;

    public function mount()
    {
        // Obtener todos los registros de cortes de caja
        $this->cortesCaja = corte_caja::all();
    }

    public function expandirCorte($id)
    {
        $this->corteSeleccionado = $id;
    }

    public function colapsarCorte()
    {
        $this->corteSeleccionado = null;
    }
    public function render()
{
    return view('livewire.cierre.reporte-cierre');
}


}
