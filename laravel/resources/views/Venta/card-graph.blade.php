<div class="row" style="margin-top: 60px; margin-bottom: 10px">
    <div wire:ignore class="col-md-12">
            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-chart-bar mr-1"></i>
                  Grafica ventas por mes
                </h3>

                <div class="card-tools">

                </div>

              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 500px; max-height: 550px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-transparent">

              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

    </div>
</div>

@section('styles')

@endsection

@section('js')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<script>

    // Sales graph chart
      var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    
      var salesGraphChartData = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre','Noviembre','Diciembre'],
        datasets: [
          {
            label: '',
            fill: false,
            borderWidth: 5,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#084d68',
            pointBackgroundColor: '#084d68',
            data: [

                  {{$listTotalVentasMes}}
    
              ]
          }
        ]
      }
      var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
      tooltips: {
        callbacks: {
          label: (item) => `Ventas $${item.yLabel}`,
        },
      },
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              fontColor: '#efefef'
            },
            gridLines: {
              display: true,
              color: '#efefef',
              drawBorder: true
            }
          }],
          yAxes: [{
            ticks: {
              stepSize: 90000,
              fontColor: '#efefef'
            },
            gridLines: {
              display: true,
              color: '#efefef',
              drawBorder: true
            }
          }]
        }
      }
      // This will get the first returned node in the jQuery collection.
      // eslint-disable-next-line no-unused-vars
      var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
      })
    
    </script>

@endsection


