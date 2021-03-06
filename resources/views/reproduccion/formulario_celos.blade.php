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
	                	<h3 class="card-title title-header">Registro de Celos</h3>
	              	</div>
	              	@if(session('msj'))
		 			<div class="alert alert-success alert-dismissible fade show" role="alert">
				  		<strong>¡Felicidades!</strong> {{ session('msj') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
		 			@endif
		 			<form action="{{ route('celos.crear',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id]) }}" method="POST" class="form-trans">
		            @csrf
		            @error('fregistro')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
	                  	<span>
	                    	<strong>¡Atención! </strong>El campo fecha registro es obligatorio.
	                  	</span>
	                  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                    	<span aria-hidden="true">&times;</span>
	                  	</button>
					</div>
	                @enderror
	                @error('resp')
	                <div class="alert alert-warning alert-dismissible fade show" role="alert">
	                  <span>
	                    <strong>Atención! </strong>El campo Responsable es requerido.
	                  </span>         
	                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                  </button>
	                </div>
	                @enderror
	              <!-- /.card-header -->
	              <div class="card-body">
		           
		              	<div class="row">
		              		<div class="col oculto">
	              				<label class="col-form-label oculto">idSerie:</label>
			                      	<input 
			                      	class="form-control oculto" 
			                      	id="idserie" 
			                      	type="text" 
			                      	name="idserie"
			                      	readonly="true" 
			                      	value="{{$series->id}}">   
	              			</div>
	              			<div class="col oculto">
	              				<label class="col-form-label oculto">dec:</label>
			                      	<input 
			                      	class="form-control oculto" 
			                      	id="dec" 
			                      	type="text" 
			                      	name="dec"
			                      	readonly="true" 
			                      	value="{{$dec}}">   
	              			</div>
	              			<div class="col">
	              				<label class="col-form-label">Serie:</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="serie" 
			                      	type="text" 
			                      	name="serie"
			                      	readonly="true" 
			                      	value="{{$series->serie}}">   
	              			</div>
		              		<div class="col">
		              				<label class="col-form-label">Fec. Nac.:
									    </label>
							    		<div class="input-group mb-3">
									  	<input 
									  	type="date" 
									  	name="fnac"
									  	id="fnac"
									  	min="1980-01-01" 
								  		max="2031-12-31"
									  	class="form-control" 
									  	readonly="true"
									  	value="{{$series->fnac}}"
									  	title="{{$series->fnac}}" 
									  	aria-label="fnac" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
		              		</div>
		              		<div class="col">
		              			<label class="col-form-label">Raza:</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="raza" 
			                      	type="text" 
			                      	name="raza"
			                      	readonly="true"
			                      	value="{{$raza->nombreraza}}">   
		              		</div>
		              		<div class="col">
	              				<label class="col-form-label">Fec. Celo Anterior:
									    </label>
							    		<div class="input-group mb-3">
									  	<input 
									  	type="date" 
									  	id="fecu"
									  	name="fecu"
									  	min="1980-01-01" 
								  		max="2031-12-31"
									  	class="form-control" 
									  	readonly="true"
									  	value="{{$series->fecuc}}"
									  	title="{{$series->fecuc}}" 
									  	aria-label="fnac" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
	              			</div>
	              			<div class="col oculto">
	              				<label class="col-form-label">Fec. Ultimo Parto:
									    </label>
							    		<div class="input-group mb-3">
									  	<input 
									  	type="date" 
									  	id="fecup"
									  	name="fecup"
									  	min="1980-01-01" 
								  		max="2031-12-31"
									  	class="form-control" 
									  	readonly="true"
									  	value="{{$series->fecup}}"
									  	title="{{$series->fecup}}" 
									  	aria-label="fecu" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
	              			</div>
	              			<div class="col">
		              			<label class="col-form-label">Fec. Registro:
									    </label>
							    		<div class="input-group mb-3">
									  	<input 
									  	type="date" 
									  	id="fregistro"
									  	name="fregistro"
									  	min="1980-01-01" 
								  		max="2031-12-31"
									  	class="form-control fregistro" 
									  	aria-label="fregistro" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
		              		</div>
		              		<div class="col">
		              			<label class="col-form-label">Responsable</label>
				                <select class="form-select" name="resp" id="resp" aria-label="select example">
	                          		<option value="" selected>Seleccione una opción</option>
	                          		@foreach($usuario as $item)
		                          	<option value="{{ $item->name}}">{{ $item->name }}</option>
		                          	@endforeach()
	                            </select>  
		              		</div>
		              	</div>
		              	<div class="row">
	              			<div class="col">
	              				<label class="col-form-label">Intervalo Entre Registro de Celos:</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="ier" 
			                      	type="text" 
			                      	name="ier"
			                      	readonly="true" 
			                      	value="{{old('$celos->dias')}}">
	              			</div>
	              			<div class="col">
	              				<label class="col-form-label">Intervalo de Días Abiertos:</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="ida" 
			                      	type="text" 
			                      	name="ida"
			                      	readonly="true" 
			                      	value="{{old('$celos->intdiaabi')}}">
	              			</div>
	              			<div class="col">
	              				<label class="col-form-label">Fec. Próximo Celo:
									    </label>
							    		<div class="input-group mb-3">
									  	<input 
									  	type="date" 
									  	id="fproxcelo"
									  	name="fproxcelo"
									  	min="1980-01-01" 
								  		max="2031-12-31"
									  	class="form-control" 
									  	readonly="true"
									  	aria-label="fnac" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
	              			</div>
		              	</div>
	              </div>
	             
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	              	<button type="submit" class="btn alert-success aling-boton">
			        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
			            <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
			        </svg> Registrar</button>
			        <a href="{{ route('ciclo.detalle',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo]) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
			          <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
			        </svg> volver</a>
	              </div>
	          </form>
	        </div>
		</div>

		<div class="col-md-12"> <!-- Col1 -->
			<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title title-header">Lista de Celos Registrados</h3>
	              	</div>
	              <!-- /.card-header -->
	              <div class="card-body">
	              <table class="table">
				        <thead>
				            <tr>
				              <th scope="col">Serie</th>
				              <th scope="col">F. Registro</th>
				              <th scope="col">Responsable</th>
				              <th scope="col">IERC</th>
				              <th scope="col">IDA</th>
				              <th scope="col">F. Próx Celo</th>
				              <th scope="col">Acción</th>
				            </tr>
				        </thead>
          				<tbody>
		         		@foreach($celos as $item)
		            		<tr>
				              <td>
				                {{ $item->serie }}
				              </td>
				              <td>
				                {{ $item->fechr }}
				              </td>
				              <td>
				                {{ $item->resp }}
				              </td>
				              <td>
				                {{ $item->dias }}
				              </td>
				               <td>
				                {{ $item->intdiaabi }}
				              </td>
				              <td>
				                {{ $item->fecestprocel }}
				              </td>
				              <td>
				               	<a href="{{route('celos.editar',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id, $item->id]) }}" class="btn alert-success btn-sm">
					              	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
					              	<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
					            	<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
					            	</svg> 
				            	</a>
				                <form action="{{route('celos.eliminar',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id, $item->id]) }}" class="d-inline form-delete" method="POST">
				                @method('DELETE')
				                @csrf
					                <button type="submit" class="btn btn-danger btn-sm">
					                	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					                	<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					              		<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
					              		</svg> 
					              	</button>
				            	</form> 
				              </td>
		            		</tr>
			        	@endforeach()
	          			</tbody>
	      			</table>	
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	              	{{$celos->links()}}
	              </div>
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
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

   <script> console.log('Hi!'); </script>
   <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
		});
   </script>


   {!! Html::script('js/jquery-3.5.1.min.js')!!}
   {!! Html::script('js/dropdown.js')!!}
   {!! Html::script('js/sweetalert2.js')!!}  

   @if(session('mensaje')=='ok')
      <script>
        Swal.fire({
        title: '¡Eliminado!',
        text:  'Registro Eliminado Satisfacoriamente',
        icon:  'success'
      })
      </script>
  @endif
  @if (session('mensaje')=='error')
      <script>
        Swal.fire({
        text:'Está siendo usado por otro recurso',
        icon: 'error',
        title:'¡No Eliminado!'
      })
      </script>
   @endif

   @if (session('celos')=='prenada')
      <script>
        Swal.fire({
        text:'No puede registrarse un Celo para una Serie Preñada',
        icon: 'info',
        title:'¡Registro de Celos!'
      })
      </script>
   @endif
    
    <script>
    
    $('.form-delete').submit(function(e){
      e.preventDefault();
      Swal.fire({
      title:'¿Está seguro que desea Eliminar el Registro?',
      text:"Este cambio es irreverible",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result)=>{
      if (result.value){
        this.submit();
      }
    })
    }); 
    </script>  

    <script>
    $('.form-trans').submit(function(e){
  
      var fecuc = new Date(document.getElementById('fecuc').value);    
      var fregistro = new Date(document.getElementById('fregistro').value);
      
      if (fecuc > fregistro) {
        e.preventDefault();
        Swal.fire({
        text:'La Fecha "Último Celo" no puede ser posterior a la fecha "Registro" del celo',
        icon: 'error',
        title:'¡Rango de Fecha No valido!'
        })
      }
    }); 
  	</script>  

@stop
