@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')

@stop

@section('content')
<div class="container">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active title-table" aria-current="page" href="#">Comparación de Trabajo Campo
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-check-all" viewBox="0 0 16 16">
        <path d="M8.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14l.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
        </svg>
        </a>
      </li>
  </ul>
<form method="GET" action="{{route('vistacomparar', $finca->id_finca)}}" role="search" class="form-trans">    
@csrf
@error('tcb')
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
	  <strong>Atención!</strong> El Trabajo de Campo B es requerido. 
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
@enderror
<div class="row my-2 mr-4 ml-4">
  <div class="col column-space">
    <div class="row">
      <div class="col">
        <label class="col-form-label title-filed">Trabajo de Campo A</label>
          <select class="form-select width-field" name="tca" aria-label="select example">
            @foreach($tc as $item)
            <option value="{{ $item->id}}" selected>{{$item->nombre}}</option>
            @endforeach()
          </select>    
      </div>
      <div class="col">
       <label class="col-form-label title-filed">Trabajo de Campo B</label>
          <select class="form-select width-field" name="tcb" aria-label="select example">
            <option value="" selected>Selecione una Opción</option>
           	@foreach($tc as $item)
            <option value="{{ $item->id}}">{{$item->nombre}}</option>
            @endforeach()
          </select> 
      </div>
      <div class="col">
        <div class="form-group">
            <button type="submit" class="btn alert-success float-left btn-ver">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-layers-half" viewBox="0 0 16 16">
			<path d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4zM8 9.433 1.562 6 8 2.567 14.438 6 8 9.433z"/>
			</svg></button>
        </div>
      </div>
  </div>
  </div> <!--/.columm-space-->
     
</div>
</form>
<div class="row mr-4 ml-4">
		@if($contA>0)
			<div class="col-md-6"> <!-- Col1 -->
				<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title title-header">Resultado A: {{$tcANombre}} </h3>
	              	</div>
	              	@if(session('msj'))
		 			<div class="alert alert-success alert-dismissible fade show" role="alert">
				  		<strong>¡Felicidades!</strong> {{ session('msj') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
		 			@endif
	              <!-- /.card-header -->
	              <div class="card-body table-responsive p-0" style="height: 300px;">
	              		<table class="table table-especie table-head-fixed text-nowrap">
				  			<thead>
							    <tr>
							      <th scope="col">Serie</th>
							      <th scope="col">Sexo</th>
							      <th scope="col">¿Paso?</th>
							      <th scope="col">Tipo</th>
							      <th scope="col">Estatus</th>
							    </tr>
				  			</thead>
				  			<tbody>
				  			@foreach($tcA as $item)
					    		<tr>
							      <th scope="row">
							      	{{$item->serie}}
							      </th>
							      <td>
							      	{!!$item->sexo?"M":"H"!!}
							      </td>
							      <td class="{!!$item->paso?"bg-success  color-palette":"bg-danger color-palette"!!}"">
							      	{!!$item->paso?"Si":"No"!!}
							      </td>
							      <td>
							      	{{$item->caso}}
							      </td>
							       <td>
							      	{!!$item->status?"Activo":"Inhabilitado"!!}
							      </td>
							    </tr>
							@endforeach()
				  			</tbody>
						</table>
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">

	              </div>
	        	</div>
			</div>
		@endif
		@if($contB>0)
		<div class="col-md-6">
			<div class="card">
	              <div class="card-header">
	                <h3 class="card-title title-header">Resultado B: {{$tcBNombre}}  </h3>
	              </div>
	              <!-- /.card-header -->
      				<div class="card-body table-responsive p-0" style="height: 300px;">
	              		<table class="table table-especie table-head-fixed text-nowrap">
				  			<thead>
							    <tr>
							      <th scope="col">Serie</th>
							      <th scope="col">Sexo</th>
							      <th scope="col">¿Paso?</th>
							      <th scope="col">Tipo</th>
							      <th scope="col">Estatus</th>
							    </tr>
				  			</thead>
				  			<tbody>
				  			@foreach($tcB as $item)
					    		<tr>
							      <th scope="row">
							      	{{$item->serie}}
							      </th>
							      <td>
							      	{!!$item->sexo?"M":"H"!!}
							      </td>
							      <td class="{!!$item->paso?"bg-success  color-palette":"bg-danger color-palette"!!}"">
							      	{!!$item->paso?"Si":"No"!!}
							      </td>
							      <td>
							      	{{$item->caso}}
							      </td>
							         <td>
							      	{!!$item->status?"Activo":"Inhabilitado"!!}
							      </td>
							    </tr>
							@endforeach()
				  			</tbody>
						</table>
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">

	              </div>
	        </div> <!--Col2 -->
		</div>
		@endif
</div>

<div class="row mr-4 ml-4">
	@if($contABNp>0)
	<div class="col-md-6"> <!-- Col1 -->
		<div class="card">
          	<div class="card-header">
            	<h3 class="card-title title-header">Resultado: Animales que NO PASARON en AXB </h3>
          	</div>
          	@if(session('msj'))
 			<div class="alert alert-success alert-dismissible fade show" role="alert">
		  		<strong>¡Felicidades!</strong> {{ session('msj') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
 			@endif

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 300px;">
          		<table class="table table-especie table-head-fixed text-nowrap">
		  			<thead>
					    <tr>
					      <th scope="col">Serie</th>
					      <th scope="col">Sexo</th>
					      <th scope="col">¿Paso?</th>
					      <th scope="col">Tipo</th>
					       <th scope="col">Estatus</th>
					    </tr>
		  			</thead>
		  			<tbody>
		  			@foreach($tcABNoPaso as $item)
			    		<tr>
					      <th scope="row">
					      	{{$item->serie}}
					      </th>
					      <td>
					      	{!!$item->sexo?"M":"H"!!}
					      </td>
					      <td class="{!!$item->paso?"bg-success  color-palette":"bg-danger color-palette"!!}"">
					      	{!!$item->paso?"Si":"No"!!}
					      </td>
					      <td>
					      	{{$item->caso}}
					      </td>
					       <td>
					      	{!!$item->status?"Activo":"Inhabilitado" !!}
					      </td>
					    </tr>
					@endforeach()
		  			</tbody>
				</table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">

          </div>
   		</div>
	</div>
	@endif
	@if($contABp>0)
	<div class="col-md-6 oculto"> <!-- Col1 -->
		<div class="card">
          	<div class="card-header">
            	<h3 class="card-title title-header">Resultado: Animales que PASARON en AXB </h3>
          	</div>
          	@if(session('msj'))
 			<div class="alert alert-success alert-dismissible fade show" role="alert">
		  		<strong>¡Felicidades!</strong> {{ session('msj') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
 			@endif

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 300px;">
          		<table class="table table-especie table-head-fixed text-nowrap">
		  			<thead>
					    <tr>
					      <th scope="col">Serie</th>
					      <th scope="col">Sexo</th>
					      <th scope="col">¿Paso?</th>
					      <th scope="col">Tipo</th>
					      <th scope="col">Estatus</th>
					    </tr>
		  			</thead>
		  			<tbody>
		  			@foreach($tcABPaso as $item)
			    		<tr>
					      <th scope="row">
					      	{{$item->serie}}
					      </th>
					      <td>
					      	{!!$item->sexo?"M":"H"!!}
					      </td>
					      <td class="{!!$item->paso?"bg-success  color-palette":"bg-danger color-palette"!!}"">
					      	{!!$item->paso?"Si":"No"!!}
					      </td>
					      <td>
					      	{{$item->caso}}
					      </td>
					        <td>
					      	{!!$item->status?"Activo":"Inhabilitado" !!}
					      </td>
					    </tr>
					@endforeach()
		  			</tbody>
				</table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">

          </div>
   		</div>
	</div>
	@endif
	@if($contm2>0)
	<div class="col-md-6 "> <!-- Col1 -->
		<div class="card">
          	<div class="card-header">
            	<h3 class="card-title title-header">Resultado: Animales que NO PASARON en A y en B </h3>
          	</div>
          	@if(session('msj'))
 			<div class="alert alert-success alert-dismissible fade show" role="alert">
		  		<strong>¡Felicidades!</strong> {{ session('msj') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
 			@endif

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 300px;">
          		<table class="table table-especie table-head-fixed text-nowrap">
		  			<thead>
					    <tr>
					      <th scope="col">Serie</th>
					      <th scope="col">Sexo</th>
					      <th scope="col">¿Paso?</th>
					      <th scope="col">Tipo</th>
					       <th scope="col">Estatus</th>
					    </tr>
		  			</thead>
		  			<tbody>
		  			@foreach($modelo2 as $item)
			    		<tr>
					      <th scope="row">
					      	{{$item->serie}}
					      </th>
					      <td>
					      	{!!$item->sexo?"M":"H"!!}
					      </td>
					      <td class="{!!$item->paso?"bg-success  color-palette":"bg-danger color-palette"!!}"">
					      	{!!$item->paso?"Si":"No"!!}
					      </td>
					      <td>
					      	{{$item->caso}}
					      </td>
					        <td>
					      	{!!$item->status?"Activo":"Inhabilitado"!!}
					      </td>
					    </tr>
					@endforeach()
		  			</tbody>
				</table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">

          </div>
   		</div>
	</div>
	@endif
	@if($contm3>0)
	<div class="col-md-6"> <!-- Col1 -->
		<div class="card">
          	<div class="card-header">
            	<h3 class="card-title title-header">Resultado: Animales que PASARON en A pero no en B </h3>
          	</div>
          	@if(session('msj'))
 			<div class="alert alert-success alert-dismissible fade show" role="alert">
		  		<strong>¡Felicidades!</strong> {{ session('msj') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
 			@endif

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 300px;">
          		<table class="table table-especie table-head-fixed text-nowrap">
		  			<thead>
					    <tr>
					      <th scope="col">Serie</th>
					      <th scope="col">Sexo</th>
					      <th scope="col">¿Paso?</th>
					      <th scope="col">Tipo</th>
					      <th scope="col">Estatus</th>
					    </tr>
		  			</thead>
		  			<tbody>
		  			@foreach($modelo3 as $item)
			    		<tr>
					      <th scope="row">
					      	{{$item->serie}}
					      </th>
					      <td>
					      	{!!$item->sexo?"M":"H"!!}
					      </td>
					      <td class="{!!$item->paso?"bg-success  color-palette":"bg-danger color-palette"!!}"">
					      	{!!$item->paso?"Si":"No"!!}
					      </td>
					      <td>
					      	{{$item->caso}}
					      </td>
					        <td>
					      	{!!$item->status?"Activo":"Inhabilitado"!!}
					      </td>
					    </tr>
					@endforeach()
		  			</tbody>
				</table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">

          </div>
   		</div>
	</div>
	@endif
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

@if(session('mensaje')=='equal')
	<script>
		Swal.fire({
		title: '¡Trabajos de Campos Iguales!',
		text:  'El Trabajo de Campo A es igual al Trabajo de Campo B',
		icon:  'warning'
	})
	</script>
@endif


@stop
