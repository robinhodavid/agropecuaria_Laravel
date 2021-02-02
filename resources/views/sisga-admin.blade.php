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
            <li><a class="dropdown-item" href="#">Lote</a></li>
            <li><a class="dropdown-item" href="#">Trasferencia</a></li>
            <li><a class="dropdown-item" href="{{ route('pajuela', $finca->id_finca)  }}">Pajuela</a></li>
            <!--<li><a class="dropdown-item" href="#">Pedigree</a></li>-->
          </ul>
        </li>
        <li class="nav-item dropdown">	
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-clone" aria-hidden="true"></i> Reproducción</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Temporada de Monta</a></li>
            <li><a class="dropdown-item" href="#">Lechera</a></li>
            <li><a class="dropdown-item" href="#">Quesera</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" 
          href="#"><i class="fa fa-leaf" aria-hidden="true"></i> Campo</a>
        </li>
        <li class="nav-item dropdown">	
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
 Reportes</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Generales</a></li>
            <li><a class="dropdown-item" href="#">Específicos</a></li>
          </ul>
        </li>
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

<a class="dropdown-item" href=" {{ route('especie', $finca->id_finca) }}">Especie</a>
<a class="dropdown-item" href="{{ route('raza', $finca->id_finca) }}">Raza</a>
<a class="dropdown-item" href="{{ route('tipologia', $finca->id_finca) }}">Tipologia</a>
<a class="dropdown-item" href="{{ route('condicion_corporal', $finca->id_finca) }}">Condiciones Corporales</a>
<a class="dropdown-item" href="{{ route('diagnostico_palpaciones', $finca->id_finca) }}">Diagnósticos de Palpaciones</a>
<a class="dropdown-item" href="{{ route('motivo_entrada_salida', $finca->id_finca)  }}">Motivos de Entrada / Salida</a>
<a class="dropdown-item" href="{{ route('patologia', $finca->id_finca)  }}">Patología</a>
<hr>
<label for="menu">ganaderia</label>
<a class="dropdown-item" href="{{ route('pajuela', $finca->id_finca)  }}">Pajuela</a>
<a class="dropdown-item" href="{{route('ficha', $finca->id_finca)}}">Ficha de Ganado</a>
</div>		     			     
</div>   
@stop

@section('content')
<div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>

@stop

@section('css')
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}
@stop
