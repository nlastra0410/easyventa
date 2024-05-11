<?php

namespace App\Livewire\Sale;

use App\Models\Client as Cliente;
use App\Models\suscripciones;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;



class Client extends Component
{


    public $cliente = '';
    public $search = '';
    public $nameClient;
    public $client;
    public $Id;
    public $name;
    public $rut;
    public $telefono;
    public $email;
    public $password;
    public $re_password;

    public $showModal = true;
    public function render()
    {

        $clients = Cliente::where('rut', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->get();

        if ($this->search != '') {
            $this->resetPage();
        }


        return view('livewire.sale.client', [
            'clients' => Cliente::all(),
            'cliente' => $clients,
            
        ]);
    }

    #[On('client_id')]
    public function client_id($id = null)
    {
        $this->client = $this->idCliente;
        $this->nameClient($id);
    }

    public function mount()
    {
        $this->nameClient();
    }

    public function nameClient($id = null)
    {
        $findClient = Cliente::find($this->idCliente);
        // Se verifica si se encontró un cliente

        if($findClient){
            $this->nameClient = $findClient->name;
        }else{
            $this->nameClient = 'Cliente no encontrado';
        }
    }

    public function store()
    {
        //dump('Crear Categoria');
        $rules = [
            'name' => 'required|min:5|max:255',
            'rut' => 'required|min:8|max:9|unique:clients',
            'telefono' => 'min:9|numeric',
            're_password' => 'same:password',
        ];
        $this->validate($rules);



        $clientes = new Cliente();
        $clientes->name = $this->name;
        $clientes->rut = $this->rut;
        $clientes->telefono = $this->telefono;
        $clientes->email = $this->email;
        $clientes->password = $this->password;

        $clientes->save();

        $this->dispatch('close-modal', 'modalClient');
        $this->dispatch('msg', 'Cliente añadido con éxito');

        $this->dispatch('client_id', $clientes->id);

        $this->clean();


    }

    public function BuscaRut($rut)
    {
        $client = Cliente::where('rut', $rut);

        if ($client == null) {
            $this->dispatch('scan-notfound', 'El cliente no se encontró');
            return;
        } else {
            $this->dispatch('close-modal', 'modalRut');
            $this->dispatch('msg', 'Cliente ingresado');
        }

        $this->showModal = false; // Cierra el modal
    }


    public function openModal()
    {
        $this->dispatch('open-modal', 'modalClient');
    }

    public function clean()
    {

        $this->reset(['Id', 'name', 'rut', 'telefono', 'email', 'password']);
        $this->resetErrorBag();
    }

    public $tieneSuscripcion;
    public $detallesSuscripcion = [];
    public $mensaje;
    public $nameCliente;
    public $idCliente;
    public function verificarSuscripcion(){
        // dd($this->rut);
        $cliente = Cliente::where('rut',$this->rut)->first();
        $suscripcion = suscripciones::where('rut_cliente',$this->rut)->first();

        // verificación de la suscripción
        if($suscripcion && $cliente){
            $fechaInicio = Carbon::parse($suscripcion->created_at);
            $fechaFin = $fechaInicio->copy()->addMonths($suscripcion->duracion);
            $hoy = Carbon::now();
            $this->nameCliente = $cliente->name;
            $this->idCliente = $cliente->id;

            if($hoy->between($fechaInicio, $fechaFin)){
                // cliente dentro del rango
                $this->tieneSuscripcion = true;
                $this->dispatch('msg','El cliente tiene una suscripción de '.$suscripcion->plan.' por '.$suscripcion->duracion.' meses.');
                $this->detallesSuscripcion = [
                    'plan' => $suscripcion->plan,
                    'duracion' => $suscripcion->duracion,
                    // Agrega más campos según sea necesario
                ];
            }else{
                // Cliente fuera del rango de suscripción
                $this->tieneSuscripcion = false;
                $this->dispatch('no-stock','La suscripcion '.$suscripcion->plan.' por '.$suscripcion->duracion.' meses del cliente ha expirado. Indicar que debe de renovar por favor.');
            }
        }else{
            $this->tieneSuscripcion = false;
            $this->dispatch('scan-notfound','El cliente no tiene suscripción.');
            $this->nameCliente = 'Generico';
            $this->idCliente = 1;
        }

        $this->dispatch('actualizarPrecios', $this->tieneSuscripcion);
    }


}
