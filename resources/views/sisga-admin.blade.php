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
          <hr>
          <li><a class="dropdown-item" href="{{route('cambio_tipologia', $finca->id_finca)}}">Cambio de Tipología</a></li>

          <li><a class="dropdown-item" href="{{route('transferencia',$finca->id_finca) }} ">Trasferencia</a></li>
          <hr>
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
          <hr>
          <li><a class="dropdown-item" href="{{ route ('reportes_transferencia', $finca->id_finca) }}"> Transferencias</a></li>
          <li><a class="dropdown-item" href="{{ route('reportes_movimientolote', $finca->id_finca) }}"> Movimiento de Lote</a></li>
          <li><a class="dropdown-item" href="{{ route('reportes_pesoajustado', $finca->id_finca)}}"> Ajuste de Peso</a></li>
          <hr>
          <li><a class="dropdown-item" href="{{ route('personreport', $finca->id_finca)}}" id="navbarDropdown" role="button">Personalizados</a></li> 
          <li><a class="dropdown-item" href="{{ route('vistamanejovientre', $finca->id_finca)}}" id="navbarDropdown" role="button">Manejo de Vientres</a></li>

          <li><a class="dropdown-item" href="{{ route('vista_reportecelo', $finca->id_finca)}}" id="navbarDropdown" role="button">Registro de Celos</a></li>  
          <hr>
          <li><a class="dropdown-item" href="{{ route('vista_reporteservicios', $finca->id_finca)}}" id="navbarDropdown" role="button">Servicios Registrados</a></li>
          <li><a class="dropdown-item" href="{{ route('vista_reportepartos', $finca->id_finca)}}" id="navbarDropdown" role="button">Partos Registrados</a></li>
          <li><a class="dropdown-item" href="#" id="navbarDropdown" role="button">Abortos Registrados</a></li>
          <hr>
          <li><a class="dropdown-item" href="#" id="navbarDropdown" role="button">Partos No Concluidos</a></li>
          <li><a class="dropdown-item" href="#" id="navbarDropdown" role="button">Series Próximas a Palpar</a></li>
          <li><a class="dropdown-item" href="#" id="navbarDropdown" role="button">Series Próximas a Parir</a></li>
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
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-venus-mars"></i></span> 

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
      <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-venus-mars"></i></span>

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
      <span class="info-box-icon bg-success elevation-1">
       <i class="far fa-object-ungroup"></i>
      </span>

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
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-venus"></i></span>

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
            Servicios Realizados
            <span class="float-right"><b>{{$ts}}</b>/{{$cantseries}}</span>
            <div class="progress progress-sm">
              <div class="progress-bar bg-ser" style="width: 80%"></div>
            </div>
          </div>
          <!-- /.progress-group -->

          <div class="progress-group">
            Series en Preñez
            <span class="float-right"><b>{{$tp}}</b>/{{$cantseries}}</span>
            <div class="progress progress-sm">
              <div class="progress-bar bg-pre" style="width:{{$tp_p}}%"></div>
            </div>
          </div>

          <!-- /.progress-group -->
          <div class="progress-group">
            <span class="progress-text">Partos Registrados</span>
            <span class="float-right"><b>{{$tpa}}</b>/{{$cantseries}}</span>
            <div class="progress progress-sm">
              <div class="progress-bar bg-par" style="width: {{$tpa_p}}%"></div>
            </div>
          </div>

          <!-- /.progress-group -->
          <div class="progress-group">
            Abortos Registrados
            <span class="float-right"><b>{{$tab}}</b>/{{$cantseries}}</span>
            <div class="progress progress-sm">
              <div class="progress-bar bg-abo" style="width: {{$tabo_p}}%"></div>
            </div>
          </div>
          <div class="progress-group">
            Partos NC Registrados
            <span class="float-right"><b>{{$tpnc}}</b>/{{$cantseries}}</span>
            <div class="progress progress-sm">
              <div class="progress-bar bg-pnc" style="width: {{$tpnc_p}}%"></div>
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
        <div class="col-sm col-6">
          <div class="description-block border-right">
            <span class="description-percentage text-pre"><i class="fas fa-caret-up"></i> {{$tp_p}}%</span>
            <h5 class="description-header">{{$tp}}</h5>
            <span class="description-text" title="Total Preñeces">TOTAL PREÑECES</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm col-6">
          <div class="description-block border-right">
            <span class="description-percentage text-par"><i class="fas fa-caret-left"></i> {{$tpa_p}}%</span>
            <h5 class="description-header">{{$tpa}}</h5>
            <span class="description-text" title="Total Partos">TOTAL PARTOS</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm col-6">
          <div class="description-block border-right">
            <span class="description-percentage text-ser"><i class="fas fa-caret-up"></i> {{$tser_p}}%</span>
            <h5 class="description-header">{{$ts}}</h5>
            <span class="description-text" title="Total Servicios Realizados">TOTAL SERVICIOS</span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm col-6">
          <div class="description-block border-right">
            <span class="description-percentage text-abo"><i class="fas fa-caret-down"></i> {{$tabo_p}}%</span>
            <h5 class="description-header">{{$tab}}</h5>
            <span class="description-text" title="Total Abortos">TOTAL ABORTOS</span>
          </div>
          <!-- /.description-block -->
        </div>
         <div class="col-sm col-6">
          <div class="description-block border-right">
            <span class="description-percentage tex-pnc"><i class="fas fa-caret-down"></i> {{$tpnc_p}}%</span>
            <h5 class="description-header">{{$tpnc}}</h5>
            <span class="description-text" title="Total Partos No Concluidos">TOTAL PARTOS N.C.</span>
          </div>
          <!-- /.description-block -->
        </div>
      </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.card-footer -->
  </div>
  <!-- /.card -->
 </div>
</div> <!-- /.row -->
<div class="row"> <!--Efectividad del Veterinario --> 
  <div class="col-md-12">
    <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title">Efectividad Veterinaria en Temporada de Reproducción</h3>
        <div class="card-tools">
           <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <div class="row">
          <div class="col">
            <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>Nombre</th>
              <th title="Porcentaje de Palpaciones">Palpaciones (%)</th>
              <th title="Efectividad Parcial de Preñez">Efect. Parcial Preñez (%)</th>
              <th title="Efectividad Parcial de Parto">Efect. Parcial Parto (%)</th>
              <th title="Efectividad Promdio">Efectividad Promedio (%)</th>
            </tr>
            </thead>
            @foreach($efectividadUser as $item)
              <tbody>
              <tr>
                <td>
                  <img src="/imagenes/userprofile.png" class="img-circle img-size-32 mr-2">
                  {{$item->name}}
                </td>
                <td style="text-align: center;">
                  <small class="{!!$item->ppalpaciones>75?"text-success":"text-danger"!!}  mr-1">
                    <i class="{!!$item->ppalpaciones>75?"fas fa-arrow-up" :"fas fa-arrow-down" !!}"></i>
                    {{$item->ppalpaciones}} %
                  </small>
                </td>
                <td style="text-align: center;">
                  <small class="{!!$item->epprenez>75?"text-success":"text-danger"!!}  mr-1">
                    <i class="{!!$item->epprenez>75?"fas fa-arrow-up" :"fas fa-arrow-down" !!}"></i>
                    {{$item->epprenez}} %
                  </small>
                </td>
                <td style="text-align: center;">
                 <small class="{!!$item->epparto>75?"text-success":"text-danger"!!}  mr-1">
                    <i class="{!!$item->epparto>75?"fas fa-arrow-up" :"fas fa-arrow-down" !!}"></i>
                    {{$item->epparto}} %
                  </small>
                </td>
                <td style="text-align: center;">
                  <small class="{!!$item->efprom>75?"text-success":"text-danger"!!}  mr-1">
                    <i class="{!!$item->efprom>75?"fas fa-arrow-up" :"fas fa-arrow-down" !!}"></i>
                     {{$item->efprom}} %
                  </small>
                </td>
              </tr>
              </tbody>
              @endforeach()
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
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

{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!}
{!! Html::script('js/jquery-3.5.1.min.js')!!}
{!! Html::script('js/dropdown.js')!!}


<script>
  $(function () {
  'use strict'
  var nroservicio =<?php echo json_encode($ns); ?>;
  var nropre =<?php echo json_encode($np); ?>;
  var nropar =<?php echo json_encode($npa); ?>;
  var nroaborto =<?php echo json_encode($na); ?>;
  var nroparnc =<?php echo json_encode($npanc); ?>;
  var graficafecha= <?php echo json_encode($meses); ?>;

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $salesChart = $('#salesChart')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : graficafecha,//['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#d7c3c3',
          borderColor    : '#3498db',
          data           : nroservicio//[18, 15, 23, 21, 17, 13, 10] //Nro. Servicios
        },
        {
          backgroundColor: '#97d6d6',
          borderColor    : '#f9e79f',
          data           : nropre//[18, 15, 23, 21, 17, 13, 10] //Nro. preñeces
        },
        {
          backgroundColor: '#d2cae2',
          borderColor    : '#2ecc71',
          data           : nropar//[8, 15, 23, 21, 17, 13, 10] //Nro. Partos
        },
        {
          backgroundColor: '#ecada6',
          borderColor    : '#ec7063',
          data           : nroaborto//[8, 15, 23, 21, 17, 13, 10] //Nro. Abortos
        },
        {
          backgroundColor: '#aab7b8',
          borderColor    : '#99a3a4',
          data           : nroparnc//[8, 15, 23, 21, 17, 13, 10] //Nro. partos N C
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 100) {
                value /= 100
                value += ''
              }
              return '' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
})
</script>


@stop
