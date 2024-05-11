<?php

namespace App\Livewire\Corte;

use App\Models\Cart;
use App\Models\corte_caja;
use App\Models\Item;
use App\Models\Sale;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class CorteCaja extends Component
{

    public $montoInicial;
    public $montoEfectivoVentas;
    public $montoActual;
    public $diferencia;
    public $usuario;
    public $gananciasNetas;
    public $montoTarjetaVentas;
    public $montoTransferenciaVentas;

    public function mount()
    {
        // Obtener los datos del usuario actualmente autenticado
        $this->usuario = Auth::user();
        $usuario = Auth::user();
        $corteCajaAbierto = $usuario->corteCajaActual();

        if ($corteCajaAbierto) {
            $this->montoInicial = $corteCajaAbierto->monto_inicial;

            // Calcular el total de las ventas realizadas en efectivo desde la apertura del corte de caja
            $ventasEfectivo = Sale::where('type', 'Efectivo')
                ->where('user_id', userID())
                ->where('created_at', '>=', $corteCajaAbierto->fecha_apertura)
                ->sum('total');

            $this->montoEfectivoVentas = $ventasEfectivo;

            $ventasTarjeta = Sale::where('type', 'Tarjeta')
                ->where('user_id', userID())
                ->where('created_at', '>=', $corteCajaAbierto->fecha_apertura)
                ->sum('total');

            $this->montoTarjetaVentas = $ventasTarjeta;

            $ventasTransferencia = Sale::where('type', 'Transferencia')
                ->where('user_id', userID())
                ->where('created_at', '>=', $corteCajaAbierto->fecha_apertura)
                ->sum('total');

            $this->montoTransferenciaVentas = $ventasTransferencia;
        }
    }

    public function actualizarDiferencia()
    {// Convertir el valor del monto actual en caja a un número
        $montoActualNumerico = is_numeric($this->montoActual) ? $this->montoActual : 0;

        // Calcular la diferencia entre el efectivo esperado y el monto actual en caja
        $this->diferencia = $this->montoInicial + $this->montoEfectivoVentas - $montoActualNumerico;
    }
    public function render()
    {

        // Obtener el corte de caja abierto del usuario
        $corteCajaAbierto = corte_caja::where('user_id', userID())
            ->whereNull('fecha_cierre')
            ->first();

        // Inicializar el monto total de ventas
        $montoTotalVentas = 0;
        $ventasHoy = 0;
        $articulosHoy = 0;
        $productosHoy = 0;

        // Verificar si se encontró un corte de caja abierto
        if ($corteCajaAbierto) {
            // Sumar el monto total de las ventas asociadas al corte de caja abierto
            $montoTotalVentas = Sale::where('user_id', userID())
                ->where('created_at', '>=', $corteCajaAbierto->fecha_apertura)
                ->sum('total');

            $ventasHoy = Sale::where('user_id', userID())
            ->where('created_at', '>=', $corteCajaAbierto->fecha_apertura)
            ->count();

            $articulosHoy = Item::where('created_at', '>=', $corteCajaAbierto->fecha_apertura)
            ->sum('qty');

            $productosHoy = count(Item::where('created_at', '>=', $corteCajaAbierto->fecha_apertura)->groupBy('product_id')->get());

                // Calcular las ganancias netas descontando el 19% de IVA
           $this->gananciasNetas = $montoTotalVentas - ($montoTotalVentas * 0.19);
        }


        return view('livewire.corte.corte-caja', [
            'montoTotalVentas' => $montoTotalVentas,
            'ventasHoy' => $ventasHoy,
            'articulosHoy' => $articulosHoy,
            'productosHoy' => $productosHoy
        ]);


    }
    public function abreCierre(){
        $usuario = auth::user();
        $corteCajaAbierto = $usuario->corteCajaActual();

        if(!$corteCajaAbierto){
            $this->dispatch('close-modal', 'modalCierre');
            $this->dispatch('scan-notfound', 'No se encontró un corte de caja abierto para este usuario');
            
        }else{
            $this->dispatch('open-modal', 'modalCierre');
        }
    }
    // public function clear()
    // {
    //     Cart::clear();
    //     $this->pago = 0;
    //     $this->devuelve = 0;
    //     $this->dispatch('msg', 'Venta cancelada');
    //     $this->dispatch('refreshProducts');

    // }

    public function registro()
    {
        //dump('Crear Categoria');
        $rules = [
            'montoActual' => 'required|numeric|min:0'
        ];

        $messages = [
            'montoActual.required' => 'Debe de ingresar el monto final',
            'montoActual.numeric' => 'El monto final debe de ser un número',
            'montoActual.min' => 'El monto final debe de ser mayor o igual a cero'
        ];
        $this->validate($rules, $messages);

        // Buscar el corte de caja abierto del usuario
        $corteCaja = corte_caja::where('user_id', userID())
            ->whereNull('fecha_cierre')
            ->first();

        // Verificar si se encontró un corte de caja abierto
        if ($corteCaja) {
            // Actualizar los atributos del corte de caja existente
            $corteCaja->monto_final = $this->montoActual;
            $corteCaja->fecha_cierre = Carbon::now();
            $corteCaja->diferencia = $this->diferencia;
            $corteCaja->save();

            $this->dispatch('close-modal', 'modalCierre');
            $this->dispatch('msg', 'Se finalizó el corte de caja, puede cerrar sesión y terminar su turno');

            $this->reset(['montoActual','diferencia']);
        } else {
            // Si no se encuentra un corte de caja abierto, mostrar un mensaje de error
            $this->dispatch('close-modal', 'modalCierre');
            $this->dispatch('scan-notfound', 'No se encontró un corte de caja abierto para este usuario');
            $this->reset(['montoActual','diferencia']);
        }


    }
}
