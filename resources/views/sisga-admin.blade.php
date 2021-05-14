@extends('adminlte::page')

@section('title', 'Sistema de Gestión Agropecuaría')

@section('content_header')
<div class="container">
<div class="row">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
   <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      	<li class="nav-item">
          <a class="nav-link" aria-current="page" 
          href="{{route ('home')}}"><i class="fa fa-home" aria-hidden="true"></i>
 Inicio</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i> Variables de Control</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href=" {{ route('especie', $finca->id_finca) }}">Especie</a></li>
            <li><a class="dropdown-item" href="{{ route('raza', $finca->id_finca) }}">Raza</a></li>
            <li><a class="dropdown-item" href="{{ route('tipologia', $finca->id_finca) }}">Tipología</a></li>
            <hr>
            <li><a class="dropdown-item" href="{{ route('condicion_corporal', $finca->id_finca) }}">Condiciones Corporales</a></li>
            <li><a class="dropdown-item" href="{{ route('colores', $finca->id_finca) }}">Colores Campo</a></li>
            <li><a class="dropdown-item" href="{{ route('diagnostico_palpaciones', $finca->id_finca) }}">Diagnósticos de Palpaciones</a></li>
            <li><a class="dropdown-item" href="{{ route('parametros', $finca->id_finca)  }}">Ganaderia - Reproducción</a></li>
            <hr>
            <li><a class="dropdown-item" href="{{ route('motivo_entrada_salida', $finca->id_finca)  }}">Motivos de Entrada / Salida</a></li>
            <li><a class="dropdown-item" href="{{ route('patologia', $finca->id_finca)  }}">Patología</a></li>
            <li><a class="dropdown-item" href="{{ route('tipomonta', $finca->id_finca)  }}">Tipo de Montas</a></li>
            <hr> 
             <li><a class="dropdown-item" href="{{ route('causamuerte', $finca->id_finca)  }}">Causa de Muerte</a></li>
              <li><a class="dropdown-item" href="{{ route('destinosalida', $finca->id_finca)  }}">Destino Salida</a></li>
              <li><a class="dropdown-item" href="{{ route('procedencia', $finca->id_finca)  }}">Procedencia</a></li>
              <hr> 
             <li><a class="dropdown-item" href="{{ route('salaordeno', $finca->id_finca)  }}">Sala de Ordeño</a></li>
              <li><a class="dropdown-item" href="{{ route('tanque', $finca->id_finca)  }}">Tanque de Enfriamiento</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">	
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-paw" aria-hidden="true"></i> Ganadería</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{route('ficha', $finca->id_finca)}}">Ficha de Ganado</a></li>
            <li><a class="dropdown-item" href="{{route('lote', $finca->id_finca)}}">Lote</a></li>
            
            <li><a class="dropdown-item" href="{{route('cambio_tipologia', $finca->id_finca)}}">Cambio de Tipología</a></li>

            <li><a class="dropdown-item" href="{{route('transferencia',$finca->id_finca) }} ">Trasferencia</a></li>
            
            <li><a class="dropdown-item" href="{{route('salida',$finca->id_finca) }}">Salida de Animales</a></li>

            <li><a class="dropdown-item" href="{{route('peso_ajustado',$finca->id_finca) }}">Ajuste de Peso</a></li>

            <li><a class="dropdown-item" href="{{ route('pajuela', $finca->id_finca)  }}">Pajuela</a></li>
            <!--<li><a class="dropdown-item" href="#">Pedigree</a></li>-->
          </ul>
        </li>
        <li class="nav-item dropdown">	
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-clone" aria-hidden="true"></i> Reproducción</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('temporada_monta', $finca->id_finca ) }}">Temporada de Reproducción Animal</a></li>
            <!--
            <li><a class="dropdown-item" href="#">Lechera</a></li>
            <li><a class="dropdown-item" href="#">Quesera</a></li>
          -->
          </ul>
        </li>
        <li class="nav-item dropdown">  
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
</svg> Reportes</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('reportes_catalogodeganado', $finca->id_finca) }}">Catálogo de Ganado</a></li>
            <li><a class="dropdown-item" href="{{ route('reportes_pajuela', $finca->id_finca) }}">Catálogo de Pajuela</a></li>
            <li><a class="dropdown-item" href="{{ route('reportes_histsalida', $finca->id_finca) }}">Historial de Salida</a></li>
            <li><a class="dropdown-item" href="{{ route ('reportes_transferencia', $finca->id_finca) }}"> Transferencias</a></li>
            <li><a class="dropdown-item" href="{{ route('reportes_movimientolote', $finca->id_finca) }}"> Movimiento de Lote</a></li>
            <li><a class="dropdown-item" href="{{ route('reportes_pesoajustado', $finca->id_finca)}}"> Ajuste de Peso</a></li>
          </ul>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario de Animales
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="{{route('inventario',$finca->id_finca)}}">Trabajo de Campo</a>
            </li>
        
          </ul>
        </li>
      </ul>
      <!--
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> 
  -->
    </div>
  </div>
</nav>
</div>

</div>

@stop

@section('content')
<div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Series Activas</span>
                    <a href="{{ route ('series_activas', $finca->id_finca) }}">
                      <span class="info-box-number">
                        {{ $cantregisactiv }}
                      </span>
                    </a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Series Inactivas</span>
                  <a href="{{ route ('series_inactivas', $finca->id_finca) }}">
                    <span class="info-box-number">{{ $cantregisinactiv }}</span>
                  </a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Series por Destetar</span>
                  <a href="{{ route('series_pordestetar', $finca->id_finca) }}">
                    <span class="info-box-number">{{$cantnodestetado}}</span>
                  </a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Hembras Reprod.</span>
                  <a href="{{ route('series_hembras_productivas', $finca->id_finca) }}">
                    <span class="info-box-number">{{$canthemrepro}}</span>
                  </a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
</div>
@if($contTemp>0)
  <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Temporada de Monta</h5>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
       
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
                        <strong>{{$nombretemporada}}</strong>
                      </p>

                      <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 478px;" width="478" class="chartjs-render-monitor"></canvas>
                      </div>
                      <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Avances Reproductivos</strong>
                      </p>

                      <div class="progress-group">
                        Series en Preñez
                        <span class="float-right"><b>160</b>/{{$cantseries}}</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->

                      <div class="progress-group">
                        Abortos Registrados
                        <span class="float-right"><b>310</b>/{{$cantseries}}</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-danger" style="width: 15%"></div>
                        </div>
                      </div>

                      <!-- /.progress-group -->
                      <div class="progress-group">
                        <span class="progress-text">Servicios Realizados</span>
                        <span class="float-right"><b>480</b>/{{$cantseries}}</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                      </div>

                      <!-- /.progress-group -->
                      <div class="progress-group">
                        Partos Registrados
                        <span class="float-right"><b>250</b>/{{$cantseries}}</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">TOTAL PREÑECES</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">TOTAL PARTOS</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">TOTAL SERVICIOS</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                      <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 0%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">TOTAL ABORTOS</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
  </div>
@endif  
@stop

@section('css')
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>
  
    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
  });
    </script>
    
    <script>
    $(function(){
      
      var ctx = document.getElementById('salesChart');
      
      var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
              label: 'Comportamiento Reproductivo',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });

   })
  

</script>

 <!--{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!} -->
    {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}

    

@stop
