<div>
    <div class="table-responsive">

        <table class="table text-center">
        
            
            <thead>

                <th>Usuario</th>
                <th>Fecha Cierre</th>
                <th>Monto Inicial</th>
                <th>Monto Final</th>
                <th>Diferencia</th>
                <th width="3%">Ver</th>

            </thead>

            @forelse ($cortesCaja as $cierre)
            <a href="{{ route('cierre.show', $cierre) }}">
                <tr>
                    <td>{{ $cierre->user->name }}</td>
                    <td>{{ $cierre->fecha_cierre }}</td>
                    <td>{{ money($cierre->monto_inicial) }}</td>
                    <td>{{ money($cierre->monto_final) }}</td>
                    <td style="font-size: 25px">
                        @if ($cierre->diferencia <= 0)
                            <span class="badge badge-success">{{ money($cierre->diferencia) }}</span>
                        @else
                            <span class="badge badge-danger">{{ money($cierre->diferencia) }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cierre.show', $cierre) }}" class="btn btn-sm" title="Ver" style="border-radius: 8px; background-color: #69C181; color: white">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
            </a>
            
            @empty
            <tr class="text-center">
                <td colspan="6">Sin registros</td>
            </tr>
            @endforelse


        </table>

    </div>

</div>
