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
            <li><a class="dropdown-item" href="{{ route('condicion_corporal', $finca->id_finca) }}">Condiciones Corporales</a></li>
            <li><a class="dropdown-item" href="{{ route('diagnostico_palpaciones', $finca->id_finca) }}">Diagnósticos de Palpaciones</a></li>
            <li><a class="dropdown-item" href="{{ route('motivo_entrada_salida', $finca->id_finca)  }}">Motivos de Entrada / Salida</a></li>
            <li><a class="dropdown-item" href="{{ route('patologia', $finca->id_finca)  }}">Patología</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">	
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-paw" aria-hidden="true"></i> Ganadería</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{route('ficha', $finca->id_finca)}}">Ficha de Ganado</a></li>
            <li><a class="dropdown-item" href="{{route('lote', $finca->id_finca)}}">Lote</a></li>
            <li><a class="dropdown-item" href="{{route('transferencia',$finca->id_finca) }} ">Trasferencia o Salida</a></li>
            <li><a class="dropdown-item" href="{{ route('pajuela', $finca->id_finca)  }}">Pajuela</a></li>
            <!--<li><a class="dropdown-item" href="#">Pedigree</a></li>-->
          </ul>
        </li>
        <li class="nav-item dropdown">	
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-clone" aria-hidden="true"></i> Reproducción</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('temporada_monta', $finca->id_finca ) }}">Temporada de Monta</a></li>
            <li><a class="dropdown-item" href="#">Lechera</a></li>
            <li><a class="dropdown-item" href="#">Quesera</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" 
          href="#"><i class="fa fa-leaf" aria-hidden="true"></i> Campo</a>
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
          </ul>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Trabajo de Campo
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Inventario</a></li>
            <li><a class="dropdown-item" href="#">Cotejo</a></li>
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

    {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}
@stop
