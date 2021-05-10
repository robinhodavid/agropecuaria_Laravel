@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12"> <!-- Col1 -->
			<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title title-header">Cambio de Tipología</h3>
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
	                <div class="card-body">
	              	<form action="{{ route ('tipologia.cambiar', $finca->id_finca) }}" method="POST">
						@csrf
			              	<div class="row">
			              		<div class="col ">
			              			<div class="row">
			              				 <label class="title-header"  for= "title">Criterios</label>
			              			</div>
			              			<!-- radio -->
				                    <div class="form-group">
				                        <div class="custom-control custom-radio">
				                          <input class="custom-control-input" type="radio" id="peso" name="criterio" checked="" value="0">
				                          <label for="peso" class="custom-control-label">Por Peso (Kg)</label>
				                        </div>
				                        <div class="custom-control custom-radio">
				                          <input class="custom-control-input" type="radio" id="edad" name="criterio" value="1">
				                          <label for="edad" class="custom-control-label">Por Edad (A-M)</label>
				                        </div>
				                        <div class="custom-control custom-radio">
				                          <input class="custom-control-input" type="radio" id="edad_peso" name="criterio" value="2">
				                          <label for="edad_peso" class="custom-control-label">Por Edad y Peso</label>
				                        </div>    
				                    </div>
			              		</div>
			              		<div class="col">
			              			<div class="row">
			              				<label class="title-header"  for= "title">Reglas</label>
			              			</div>
			              			<div class="row">
			              				<div class="col">
			              					<label class="my-2">Peso Mayor o Igual A:</label>
							                    <input 
								                  class="form-control porpeso" 
								                  id="porpeso" 
								                  type="number" 
								                  name="peso"  
								                  placeholder="Peso (Kg)" 
								                  value="{{ old('nro_monta') }}"
								                  min="0" pattern="^[0-9]+">
			              				</div>
			              				<div class="col">
			              					 <label class="my-2">Edad Mayor o Igual A:</label>
							                    <input 
								                  class="form-control" 
								                  id="poredad" 
								                  type="text" 
								                  name="edad"  
								                  placeholder="Edad (A-M)" 
								                  value="{{ old('nro_monta') }}"
								                  >      
			              				</div>

			              			</div>	
			              			
						           
			              		</div>
			              	</div>
			              	<div class="row">
			              		<div class="col">
			              			<label class="col-form-label">Tipología Actual:</label>
				                      	<select class="form-select" id="ta" name="tipo_actual" aria-label="select example">
				                      		<option value=" " checked>Seleccione una opción </option>
			                      			@foreach ($tipologiaActualMacho as $item)
			                          		<option value="{{ $item->nombre_tipologia }}">{{ $item->nombre_tipologia}}
			                          		</option>
		                      				@endforeach()
		                      				@foreach ($tipologiaActualHembra as $item)
			                          		<option value="{{ $item->nombre_tipologia }}">{{ $item->nombre_tipologia}}
			                          		</option>
		                      				@endforeach()	
		                        		</select>  
			              		</div>
			              		<div class="col">
			              			<label class="my-2">Tipología Propuesta:</label>
					                    <input 
						                  class="form-control" 
						                  id="tipopropuesta" 
						                  type="text" 
						                  name="tipopropuesta"   
						                  value=""
						                  readonly="true" 
						                  >      
			              		</div>
			              	</div>

	                </div>
		              	<!-- /.card-body -->
		                <div class="card-footer clearfix">
		              	    <button type="submit" class="btn alert-success aling-boton">
						        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
						            <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
						        </svg> Cambiar</button>
					        <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
					          <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
					        </svg> volver</a>
		                </div>
	           		</form>  
	        </div>
		</div>
	</div>
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
    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
});
    </script>
  {!! Html::script('js/jquery-3.5.1.min.js')!!}
  {!! Html::script('js/dropdown.js')!!}
    

@stop
