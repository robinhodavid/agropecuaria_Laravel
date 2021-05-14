@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')

@stop

@section('content')
<div class="container">
	<!--
	<div class="row">
		<div class="col">
      	<input 
          class="aling-boton"
          type="radio" 
          aria-label="Radio button for following text input"
          name="tipo"
          id="tipo1" value="0">
          <label class="checkbox-inline aling-boton"  for= "tipo">Listado</label>
        <input 
          class="aling-boton"
          type="radio" 
          aria-label="Radio button for following text input"
          name="tipo"
          id="tipo2" value="1" checked>
          <label class="checkbox-inline aling-boton"  for="tipo">Tipología</label>
        </div>  
	</div> -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active title-table" aria-current="page" href="#">Trabajo de Campo
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-check-all" viewBox="0 0 16 16">
        <path d="M8.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14l.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
        </svg>
        </a>
      </li>
  </ul>
<form method="GET" action="{{route ('tc.detalle',[$finca->id_finca,$tc->id]) }}" role="search"  class="form-trans">    
@csrf
<div class="row my-2 mr-4 ml-4">
<!--
@if(session('msj'))
 	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong>¡Felicidades!</strong> {{ session('msj') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
	</div>
 @endif -->
  <div class="col column-space">
  	<div class="row">
  		<div class="col">
	    	<label class="title-filed">Serie</label>
	          <input 
	              type="text" 
	              id="serie"
	              name="serie"
	              class="form-control" 
	              aria-label="serie" aria-describedby="basic-addon2"
	              placeholder="Serie...">
	    </div>
	    <div class="col-4 tip">
	        <label class="col-form-label title-filed">Tipología</label>
	          <select class="form-select width-field" name="tipo" aria-label="select example">
	            <option value="" selected>Tipología</option>
	              @foreach($tipologia as $item)
	                <option value="{{$item->id_tipologia}}"> {{$item->nombre_tipologia}}
	                </option>
	              @endforeach()
	          </select>    
	    </div>
	<!--
	    <div class="col list">
	    	<label class="col-form-label title-filed">Listado de Campo</label>
	          <select class="form-select width-field" name="list" aria-label="select example">
	            <option value="" selected>Selecione una Opción</option>
	            <option value="1">Series Próximas a Parir</option>
	            <option value="2">Series próximos a Destetar</option>
	            <option value="3">Series Destetados</option>
	          </select>  	
	    </div>
	    <div class="col list">
	    	<label class="title-filed">Desde</label>
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
	    <div class="col list">
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
	-->
	  	<div class="col">
	        <div class="form-group">              
	            <button type="submit" class="btn alert-success float-left btn-ver">
	            <i class="fas fa-search"></i></button>
	        </div>
        </div>
	     
	</div>         
  </div> <!--/.columm-space-->
     
</div>
</form>
<form method="POST" action="{{route ('tc.guardar',[$finca->id_finca,$tc->id]) }}" role="search"  class="form-trans">    
@csrf
<div class="row mr-4 ml-4">
@if(session('msj'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>¡Felicidades!</strong> {{ session('msj') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@if(session('mesaj'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>¡información!</strong> {{ session('mesaj') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@error('id')
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Atención!</strong> La serie ya fue registrada.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@enderror
    <div class="table">
        <table class="table">
          <thead class="title-table">
            <tr>
              <th scope="col" style="text-align: center;">#</th>
              <th scope="col" style="text-align: center;">Serie</th>
              <th scope="col" style="text-align: center;">Sexo</th>
              <th scope="col" style="text-align: center;">Edad</th>
              <th scope="col" style="text-align: center;">Tipología</th>
              <th scope="col" style="text-align: center;">C. Mad</th>
              <th scope="col" style="text-align: center;">¿Pasó?</th>
              <th scope="col" style="text-align: center;">Diagnóstico</th>
              <th scope="col" style="text-align: center;">Evaluación</th>
              <th scope="col" style="text-align: center;">Observación</th>
            </tr>
         </thead>
          <tbody>
         @foreach($series as $item)
            <tr class="text-body-table">
              	<td style="width: 5%;text-align: center;">
                    <div class="form-check">        
                        <input 
                        class="form-check-input" 
                        type="checkbox" 
                        value="{{ $item->id}}" id="id_serie"
                        name="id[]">
                  </div> 
              	</td>
	            <td style="width: 5%;text-align: center;">
	                {{ $item->serie }}
	            </td>
              	<td style="width: 5%;text-align: center;">                
                	{!!$item->sexo?"M":"H" !!}
              	</td>
              	<td style="width: 5%;text-align: center;">
               	 	{{ $item->edad }}
              	</td>
               	<td style="width: 10%; text-align: center;">
                	{{ $item->tipo }}
              	</td>
              	<td style="width: 8%;text-align: center;">
                	{{ $item->codmadre}}
              	</td>
              	<td style="width: 9%;text-align: center;">
                    <select class="form-select" name="paso[]" id="paso" aria-label="select example">
	                    <option value="1" selected>Sí</option>
	                    <option value="0">No</option>
                  	</select>    
              	</td>
              	<td style=" width: 12%; text-align: center;">
                  <select class="form-select" name="diagnostico[]" id="diagnostico" aria-label="select example">
                    <option value="" selected>Seleccione una opción</option>
                    @foreach($diagnostic as $item)
                    <option value="{{ $item->nombre}}">{{ $item->nombre }}</option>
                    @endforeach()
                  </select>    
              	</td>
              	<td style="width: 12%; text-align: center;">
                  	<select class="form-select" name="patologia[]" id="patologia" aria-label="select example">
                    <option value="" selected>Ninguna</option>
                    @foreach($patologias as $item)
                    <option value="{{ $item->patologia}}">{{ $item->patologia }}</option>
                    @endforeach()
                  </select>
              	</td>
              	<td style="text-align: center;">
                    <input 
                    class="form-control" 
                    type="text" 
                    value="{{ old('observacion') }}" id="observacion"
                    name="observacion[]">
              	</td>
            </tr>
          </tbody>
          @endforeach()
        </table>
        <div class="footer-table title-table">
          {{ $series->links() }}
        </div>             
    </div>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
	<button type="submit" class="btn alert-success aling-boton">
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
    <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
	</svg> Registrar</button>
	<a href="{{ route('home') }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
	<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
	</svg> volver</a>
</div>
</form>
<!--Tabla detalle -->
<div class="row">
	    <div class="table">
        <table class="table">
          <thead class="title-table">
            <tr>
              <th scope="col" style="text-align: center;">Serie</th>
              <th scope="col" style="text-align: center;">Sexo</th>
              <th scope="col" style="text-align: center;">Edad</th>
              <th scope="col" style="text-align: center;">Tipología</th>
              <th scope="col" style="text-align: center;">C. Mad</th>
              <th scope="col" style="text-align: center;">¿Pasó?</th>
              <th scope="col" style="text-align: center;">Diagnóstico</th>
              <th scope="col" style="text-align: center;">Evaluación</th>
              <th scope="col" style="text-align: center;">Observación</th>
            </tr>
         </thead>
          <tbody>
         @foreach($tcdetalle as $item)
            <tr class="text-body-table">
	            <td style="width: 5%;text-align: center;">
	                {{ $item->serie }}
	            </td>
              	<td style="width: 5%;text-align: center;">                
                	{!!$item->sexo?"M":"H" !!}
              	</td>
              	<td style="width: 5%;text-align: center;">
               	 	{{ $item->edad }}
              	</td>
               	<td style="width: 10%; text-align: center;">
                	{{ $item->tipo }}
              	</td>
              	<td style="width: 8%;text-align: center;">
                	{{ $item->codmadre}}
              	</td>
              	<td style="width: 9%;text-align: center;">
                    {!! $item->paso?"Si":"No"!!}
              	</td>
              	<td style=" width: 12%; text-align: center;">
             		{{$item->diagnostico}}   
              	</td>
              	<td style="width: 12%; text-align: center;">
              		{{$item->evaluacion}}
              	</td>
              	<td style="text-align: center;">
                    {{$item->observacion}}
              	</td>
            </tr>
          </tbody>
          @endforeach()
        </table>
        <div class="footer-table title-table">
          {{ $tcdetalle->links() }}
        </div>             
    </div>
</div>
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

@if (session('msjinfo')=='ok')
  	<script>
	    Swal.fire({
	    text:'Seleccione al menos un Nro. Serie',
	    icon: 'info',
	    title:'¡Trabajo de Campo!'
	    })
  	</script>
@endif


@stop
