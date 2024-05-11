<?php

namespace App\Livewire\Impresoras;
use Symfony\Component\Process\Process;

use Livewire\Component;

class VerImpresora extends Component
{

    public $impresorasDisponibles = [];

    public function mount()
    {
        $this->obtenerImpresorasDisponibles();
    }

    public function obtenerImpresorasDisponibles()
    {
        // Ejecutar un comando para obtener las impresoras disponibles en el sistema
        $process = new Process(['lpstat', '-a']);
        $process->run();

        // Obtener el resultado del comando
        if ($process->isSuccessful()) {
            $output = $process->getOutput();
            // Separar las líneas del resultado en un array
            $impresoras = explode("\n", trim($output));
            // Eliminar el primer elemento, que es un encabezado
            array_shift($impresoras);
            // Asignar las impresoras disponibles al array de impresoras
            $this->impresorasDisponibles = $impresoras;
        } else {
            // Manejar el caso de error
            $this->impresorasDisponibles = ['Error al obtener impresoras'];
        }
    }
    public function render()
    {
        return view('livewire.impresoras.ver-impresora');
    }
}
