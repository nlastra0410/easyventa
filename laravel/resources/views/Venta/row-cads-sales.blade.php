<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $ventasHoy }}</h3>

          <p>Ventas hoy</p>
        </div>
        <div class="icon">
            <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <a href="" class="small-box-footer">Ir a ventas <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3>{{money($montoTotalVentas)}}</h3>

          <p>Total ventas hoy</p>
        </div>
        <div class="icon">
            <i class="fas fa-money-check-alt"></i>
        </div>
        <a href="" class="small-box-footer">Ir a ventas <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{$articulosHoy}}</h3>

          <p>Articulos vendidos hoy</p>
        </div>
        <div class="icon">
            <i class="fas fa-shopping-basket"></i>
        </div>
        <a href="" class="small-box-footer">Ir a ventas <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{$productosHoy}}</h3>

          <p>Productos vendidos hoy</p>
        </div>
        <div class="icon">
            <i class="fa-solid fa-pills"></i>
        </div>
        <a href="" class="small-box-footer">Ir a productos <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
</div>