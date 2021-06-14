@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')

@stop

@section('content')
<div class="container">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active title-table" aria-current="page" href="#">Catalogo de Ganado
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-check-all" viewBox="0 0 16 16">
        <path d="M8.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14l.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
        </svg>
        </a>
      </li>
  </ul>
<form method="GET" action="{{ route('catalago.reporte', $finca->id_finca) }}" role="search" target="_blank" class="form-trans">    
@csrf
<div class="row my-2 mr-4 ml-4">
  <div class="col column-space">
    <div class="row">
      <div class="col">
        <label class="col-form-label title-filed">Tipología</label>
          <select class="form-select width-field" name="tipo" aria-label="select example">
            <option value="" selected>Tipología</option>
              @foreach($tipologia as $item)
                <option value="{{$item->id_tipologia}}"> {{$item->nombre_tipologia}}
                </option>
              @endforeach()
          </select>    
      </div>
      <div class="col">
       <label class="col-form-label title-filed">Lote</label>
          <select class="form-select width-field" name="lote" aria-label="select example">
            <option value="" selected>Lote</option>
              @foreach($lote as $item)
                <option value="{{$item->nombre_lote}}"> {{$item->nombre_lote}}
                </option>
              @endforeach()
          </select> 
      </div>
      <!--
      <div class="col">
       <label class="col-form-label title-filed">Sublote</label>
          <select class="form-select width-field" name="sublote" aria-label="select example">
            <option value="" selected>Sublote</option>
            <option value="Lote 1"> Lote 1 </option>
            <option value="Lote 2"> Lote 2 </option>
            <option value="Lote 3"> Lote 3 </option>
            <option value="Lote 4"> Lote 4 </option>
            <option value="Lote 5"> Lote 5 </option>
          </select> 
      </div>
    -->
      <div class="col">
        <label class="title-filed">Registro Desde</label>
        <div class="input-group mb-3">
          <input 
                type="date" 
                id="desde"
                name="desde"
                class="form-control" 
                min="1980-01-01" 
                max="2031-12-31"
                aria-label="desde" aria-describedby="basic-addon2">
              <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
              <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
              </svg></span>  
        </div>    
      </div>
      <div class="col">
        <label class="title-filed">Hasta</label>
        <div class="input-group mb-3">
          <input 
              type="date" 
              id="hasta"
              name="hasta"
              class="form-control" 
              min="1980-01-01" 
              max="2031-12-31"
              aria-label="hasta" aria-describedby="basic-addon2">
              <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
              <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
              </svg></span> 
        </div>   
      </div>
      <!--
      <div class="col">
        <div class="form-group">
               
            <button type="submit" class="btn alert-success float-left btn-ver">
            <i class="fas fa-print"></i></button>

        </div>
      </div>
    -->
  </div>
  </div> <!--/.columm-space-->
      <div class="card-footer clearfix">
                  <h6 ><strong>Ordenar por:</strong></h6> 
                  <div class="col">
                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="orderby"
                    id="campo1" value="sganims.serie" checked>
                    <label class="checkbox-inline title-label"  for="campo1">Serie</label>

                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="orderby"
                    id="campo2" value="sganims.id_tipologia">
                    <label class="checkbox-inline title-label"  for="campo2">Tipología</label>

                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="orderby"
                    id="campo3" value="sganims.codmadre">
                    <label class="checkbox-inline title-label"  for="campo3">Código Madre</label>

                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="orderby"
                    id="campo4" value="sganims.fecr">
                    <label class="checkbox-inline title-label"  for="campo4">Fecha Registro</label>

                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="orderby"
                    id="campo5" value="sganims.sexo">
                    <label class="checkbox-inline title-label"  for="campo5">sexo</label>
                  </div>
                  <div class="col">
                    <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg> </a>
                    <button type="submit" class="btn alert-success float-right btn-sm"><i class="fas fa-print"></i></button>
                  </div>
                </div> 
</div>
</form>


</div>

@stop

@section('css')

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<!-- daterange picker -->
<link rel="stylesheet" href="/daterangepicker/daterangepicker.css">
  
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  
<!-- Select2 -->
<link rel="stylesheet" href="/select2/css/select2.min.css">
<link rel="stylesheet" href="/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
   
  
<!-- Todo esto para e date picker-->
  <!-- bootstrap color picker -->
  <script src="/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- moment -->
  <script src="/moment/moment.min.js"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!--Todo esto para el date picker-->
  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
	   });
  </script>
    
	{!! Html::script('js/jquery-3.5.1.min.js')!!}
  {!! Html::script('js/dropdown.js')!!}
  {!! Html::script('daterangepicker/daterangepicker.js')!!}  
  {!! Html::script('js/sweetalert2.js')!!}  
  <!-- Page script -->

<script>
    
    $('.form-trans').submit(function(e){
  
      var desde = new Date(document.getElementById('desde').value);    
      var hasta = new Date(document.getElementById('hasta').value);
      
      if (desde > hasta) {
        e.preventDefault();
        Swal.fire({
        text:'La Fecha "Hasta" no puede ser anterior a la fecha "Desde"',
        icon: 'error',
        title:'¡Rango de Fecha No valido!'
        })
      }
    }); 
</script>


@stop
