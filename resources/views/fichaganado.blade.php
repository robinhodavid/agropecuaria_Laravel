@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
   
@stop

@section('content')
 
 @if(session('msj'))
 	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong>¡Felicidades!</strong> {{ session('msj') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
	</div>
 @endif
<div class="container">
	<div class="row my-2">
		<div class="form-registro">
			<form action="{{ route('fichaganado.crear',$finca->id_finca) }}" method="POST">
				@csrf
				@error('serie')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>¡Atención! </strong>El campo Serie es obligatorio o <strong>Ya existe</strong>
				  </span>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('sexo')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo sexo es requerido.
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('fnac')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo Fecha de Nacimiento es requerido.
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('tipologia')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo Tipología es requerido
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('raza')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo Raza es requerido.
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('condicion_corporal')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo Condición Corporal es requerido.
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('fecr')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo Fecha de Registro es requerido.
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				<div class="row mb-2">
				<div class="col my-3">
					<div class="title-header">Ficha de Gando</div>
				</div>
			  		<div class="form-group">
			  			<div class="col border-top border-right border-left border-bottom card-ficha-ganado">
			  				<div class="row mb-2">
			  					<div class="col-3 oculto">
					  				<label class="col-form-label oculto">idfinca:</label>
					                <input 
					                class="form-control oculto" 
					                id="id_finca" 
					                type="text" 
					                name="id_finca"  
					                placeholder="Ingrese el Nro. de Pajuela" 
					                value="{{ $finca->id_finca }}"> 
								</div>
								<div class="col-4">
					  				<label class="col-form-label">Serie:</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="serie" 
			                      	type="text" 
			                      	name="serie"  
			                      	placeholder="Serie" 
			                      	value="{{ old('serie') }}">   
								</div>
								<div class="col-4">
								    <label class="col-form-label">Fec. Nac.:
								    </label>
						    		<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fnac"
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	aria-label="fnac" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>
								</div> 	
							    </div>
				  				<div class="col-4">
					  				<label class="col-form-label">Sexo:</label>
								    <select class="form-select" name="sexo" 
								    id="sexo" aria-label="select example">
		                            <option value=" " selected>Seleccione una opción</option>
		                         	<option value="0">Hembra</option>
		                          	<option value="1">Macho</option>
		                          	</select> 
								</div>
								<div class="col-4">
					  				<label class="col-form-label">Tipología:</label>
								    {!! Form::select('tipologia',[''=>'Seleccione un opción'],null,['id'=>'tipologia' ,'class'=>'form-select']) !!}
								</div>
							    <div class="col-4">
					  				<label class="col-form-label">Raza:</label>
			                      	<select class="form-select" name="raza" aria-label="select example">
                          			<option value="" selected>Seleccione una opción</option>
                          			@foreach ($raza as $item)
	                          		<option value="{{ $item->idraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
	                          		</option>
                          			@endforeach()	
                            		</select>  
								</div>
								<div class="col-4">
								    <label class="col-form-label">Condición Corporal:</label>
						    		<select class="form-select" name="condicion_corporal" aria-label="select example">
                          			<option value="" selected>Seleccione una opción</option>
                          			@foreach ($condicion_corporal as $item)
	                          		<option value="{{ $item->id_condicion }}">{{ $item->nombre_condicion }}
	                          		</option>
                          			@endforeach()	
                            		</select>
							    </div>
			                    <div class="col-4">
			                      	<label class="col-form-label">Lote Estratégico:</label>
			                      	<select class="form-select" name="lote" aria-label="select example">
				                        <option value="" selected>Seleccione una opción</option>
				                        @foreach ($lote as $item)
	                          				<option value="{{ $item->nombre_lote }}">{{ $item->nombre_lote }}
			                          		</option>
                          				@endforeach()
			                       </select> 
			                    </div>
			                    <div class="col-4">
					  				<label class="col-form-label">Cod. Madre</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="codmadre" 
			                      	type="text" 
			                      	name="codmadre"  
			                      	placeholder="Serie Madre" 
			                      	value="{{ old('codmadre') }}">   
								</div>
								<div class="col-4">
									<div class="row">
										<div class="col-6">
											<label class="col-form-label">Cod. Padre</label>
										</div>
										<div class="col-6">
											<div class="form-check form-switch">
						                         <input class="form-check-input form-check-input-paju"
						                         type="checkbox" 
						                         id="espajuela"
						                         name="espajuela"

						                         >
						                         <label class="col-form-label" for="espajuela">¿Es Pajuela?</label>
					                      	</div>
				                      	</div>
			                      	</div>
			                      	<select class="form-select" id="pajuela" name="pajuela" aria-label="select example">
				                        <option value="" selected>Seleccione una opción</option>
				                        @foreach ($pajuela as $item)
	                          				<option value="{{ $item->serie }}">{{ $item->serie }}
			                          		</option>
                          				@endforeach()
			                        </select>
				                     <select class="form-select" id="seriepadre" name="seriepadre" aria-label="select example">
				                        <option value="" selected>Seleccione una opción</option>
				                        @foreach ($serietoro as $item)
	                          				<option value="{{ $item->codpadre }}">{{ $item->codpadre }}
			                          		</option>
                          				@endforeach()
			                        </select> 		
								</div>
			  				</div>
			  			</div>
			  		</div>
			  	</div>
			  	<div class="row mb-2">
			  		<div class="form-group">
			  			<div class="col border-top border-right border-left border-bottom card-ficha-ganado">
			  				<div class="row mb-4">
			  					<div class="col-4">
					  			<label class="col-form-label">Fec. Registro:</label>
								<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fecr"
								  	class="form-control" 
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	aria-label="fecr" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>
								</div> 	
								</div>
				  				<div class="col-4">
					  				<label class="col-form-label">Peso Inicial:</label>
								    <input 
								    class="form-control" 
								    id="pesoi" 
								    type="number" 
								    name="pesoi" 
								    min="0" 
								    step="any"
								    placeholder="Peso inicial" 
								    value="{{ old('pesoi') }}">	
								</div>
								<div class="col-4">
								    <label class="col-form-label">Procedencia:</label>
								    <input 
								    class="form-control" 
								    id="procede" 
								    type="text" 
								    name="procede"  
								    placeholder="Procedencia" 
								    value="{{ old('procede') }}">
							    </div>
				  				<div class="col">
			  					<label class="col-form-label">Observación:</label>
								    <input 
								    class="form-control text-area" 
								    id="observa" 
								    type="text"
								    name="observa"
								    maxlength="130"								    
								    value="{{ old('observa') }}">
			  					</div>
			  				</div>
			  			</div>
			  		</div>
			  	</div>
			  	<a href="{{route('admin',$finca->id_finca)}}" class="btn btn-warning float-rigth"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
	  			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
				</svg> volver</a>

				<button type="submit" class="btn alert-success float-rigth">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                 <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                </svg> Registrar</button>

                

			</form>		
		</div>
	</div>
</div>

<div class="container">
	<div class="row my-4 border-top border-right  border-bottom border-style">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Serie</th>
		      <th scope="col">Tipología</th>
		      <th scope="col">Cod. Madre</th>
		      <th scope="col">Lote</th>
		      <th scope="col">Sub Lote</th>
		      <th scope="col">Peso actual</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody> 	
		  	@foreach($seriesrecords as $item)
			    <tr>
			      <td>
			      	<a href=" " class="">
			      	{{ $item->serie }}
			      	</a>
			      </td>
			       <td>
					{{ $item->nomenclatura }}		      
			      </td>
			      <td>
			      	{{ $item->codmadre }}
			      </td>
			      <td>
					{{ $item->nombrelote }}		      
			      </td>
			      <td>
			      	{{ $item->sub_lote }}	
			      </td>
			      <td>
			      	{{ $item->pesoactual }}
			      </td>
			      <td>
			      	<a href="{{ route('fichaganado.editar', [$finca->id_finca, $item->id]) }}" class="btn alert-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  					<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
 					<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
					</svg> </a>
			      </td>
			    </tr>
		   @endforeach()
		  </tbody>
		</table>
	</div>
			<div class="link">
		{{  $seriesrecords->links() }}
		</div>
</div>
@stop

@section('css')

<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  

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
