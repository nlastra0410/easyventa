<div class="col-6" style="align-items: center; text-align: center">
    <h1 class="fecha">
    </h1>

    <div class="reloj" style="color:  white; font-size:25px">
        <p class="tiempo"></p>
    </div>
</div>

<script defer>
    const $tiempo = document.querySelector('.tiempo'),
        $fecha = document.querySelector('.fecha');

    function digitalClock() {
        let f = new Date(),
            dia = f.getDate(),
            mes = f.toLocaleDateString('es-ES', { month: 'long' }), // Obtener el nombre del mes
            anio = f.getFullYear(),
            diaSemana = f.getDay();

        dia = ('0' + dia).slice(-2);

        let timeString = f.toLocaleTimeString();
        $tiempo.innerHTML = timeString;

        let semana = ['DOM', 'LUM', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB'];
        let showSemana = (semana[diaSemana]);
        $fecha.innerHTML = `${showSemana} ${dia} de ${mes} de ${anio}`; // Mostrar el nombre del mes
    }

    setInterval(() => {
        digitalClock();
    }, 1000);

    // Llamar a la función digitalClock una vez que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', digitalClock);
</script>

