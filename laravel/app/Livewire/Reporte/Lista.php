<?php

namespace App\Livewire\Reporte;

use App\Models\Category;
use App\Models\Client;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('EasyVenta/Reportes')]


class Lista extends Component
{
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 5;
    public $totalVentas = 0;
    public $dateInicio;
    public $dateFin;
    public $listTotalVentasMes = '';

    // Cajas de reporte
    public $cantidadVentas = 0;
    public $totalventas = 0;
    public $cantidadArticulos = 0;
    public $catidadProductos = 0;
    public $cantidadProducts = 0;
    public $cantidadStock = 0;
    public $cantidadClients = 0;
    public $cantidadCategories = 0;

    public function calVentasMes(){
        for ($i=1; $i <= 12 ; $i++) { 
            $this->listTotalVentasMes .= Sale::whereMonth('fecha', '=', $i)->sum('total').',';
        }
    }

    public function boxes_reports(){
        $this->cantidadVentas = Sale::whereYear('fecha','=',date('Y'))->count();
        $this->totalVentas = Sale::whereYear('fecha','=',date('Y'))->sum('total');
        $this->cantidadArticulos = Item::whereYear('fecha','=',date('Y'))->sum('qty');
        $this->catidadProductos = count(Item::whereYear('fecha','=',date('Y'))->groupBy('product_id')->get());

        $this->cantidadProducts = Product::count();
        $this->cantidadStock = Product::sum('stock');
        $this->cantidadCategories = Category::count();
        $this->cantidadClients = Client::count();
    }

    public function render()
    {

        $this->calVentasMes();
        $this->boxes_reports();
        if($this->search!=''){
            $this->resetPage();
        }

        $this->totalRegistros = Sale::count();
        $salesQuery = Sale::where('id','like','%'.$this->search.'%');


        if($this->dateInicio && $this->dateFin){
            $salesQuery = $salesQuery->whereBetween('fecha',[$this->dateInicio, $this->dateFin]);

            $this->totalVentas = $salesQuery->sum('total');
        }else{
            $this->totalVentas = Sale::sum('total');
        }



        $sales = $salesQuery  
                ->orderBy('id','desc')
                ->paginate($this->cant);$sales =Sale::where('id','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.reporte.lista',[
            "sales" => $sales
        ]);
    }

    #[On('destroySale')]
    public function destroy($id){
        $sale = Sale::findOrFail($id);

        foreach($sale->items as $item){
            Product::find($item->id)->increment('stock',$item->qty);
            $item->delete();
        }

        $sale->delete();

        $this->dispatch('msg','Venta eliminada');

    }

    #[On('setDates')]
    public function setDates($fechaInicio,$fechaFinal){

        $this->dateInicio = $fechaInicio;
        $this->dateFin = $fechaFinal;
        // dump($fechaInicio, $fechaFinal);
    }
}
