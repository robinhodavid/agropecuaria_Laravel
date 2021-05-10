@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row my-2">
		<h3 class="title-header">Parámetros de Control</h3>
  		<div class="col"> 
    		<div role="tabpanel">
			    <ul class="nav nav-tabs" role="tablist">
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Ganadería</a>
			      </li>
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link" href="#seccion2" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Reproducción</a>
			      </li>
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link" href="#seccion3" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Producción Lechera</a>
			      </li>
			    </ul>
    			<div class="tab-content">
      			<div class="tab-pane active" role="tabpanel" id="seccion1">
      				<form action="{{ route('parametros_ganaderia.crear', $finca->id_finca) }}" method="POST" class="form-trans">
        			@csrf
      					<div class="col-md-12 my-2"> <!-- Col1 -->
      				@if(session('msj'))
			          <div class="alert alert-success alert-dismissible fade show" role="alert">
			              <strong>¡Felicidades!</strong> {{ session('msj') }}
			            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                <span aria-hidden="true">&times;</span>
			            </button>
			          </div>
			        @endif		
					<div class="row my-4">
						<div class="col">
							<label class="col-form-label title-tipo">Días al Destete: </label>
							<input 
			              	class="form-control" 
			              	id="diasaldestete" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0"
			              	name="diasaldestete"
			              	value="{{old('$parametrosGanaderia->diasaldestete') }}"
			              	{!! $contpG>0?"readonly=true":"" !!}>
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado al Destete: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajustdestete" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	name="pajustdestete"
			              	placeholder="0"
			              	value="{{old('$parametrosGanaderia->pesoajustadoaldestete') }}"
			              	{!! $contpG>0?"readonly=true":"" !!}>
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado 12 meses: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajust12m" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0" 
			              	name="pajust12m"
			              	value="{{old('$parametrosGanaderia->pesoajustado12m') }}"
			              	{!! $contpG>0?"readonly=true":"" !!}>	
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado 18 meses: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajust18m" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0" 
			              	name="pajust18m"
			              	value="{{old('$parametrosGanaderia->pesoajustado18m') }}"
			              	{!! $contpG>0?"readonly=true":"" !!}>	
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado 24 meses: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajust24m" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0" 
			              	name="pajust24m"
			              	value="{{old('$parametrosGanaderia->pesoajustado24m') }}"
			              	{!! $contpG>0?"readonly=true":"" !!}>
						</div>
					</div>
					<div class="row">
						<div class="card-footer clearfix">
				            @if($contpG > 0)

				            @else
				            <button type="submit" class="btn alert-success aling-boton">
				            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
				                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
				            </svg> Registrar</button>
				            @endif
				            <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
				              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
				            </svg> volver</a>
  						</div>
					</div>
				</div>
				</form>	
				<div class="col-md-12 my-4">
					<table class="table table-striped title-tipo">
	                  <thead>
	                    <tr>
	                      <th style="width: 15%; text-align: center;">Días al Destete</th>
	                      <th style="width: 15%; text-align: center;">PA al Destete (días)</th>
	                      <th style="width: 15%; text-align: center;">PA 12m (días)</th>
	                      <th style="width: 15%; text-align: center;">PA 18m (días)</th>
	                      <th style="width: 15%; text-align: center;">PA 24m (días)</th>
	                      <th style="width: 20%; text-align: center;">Acción</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                  	@foreach($parametrosGanaderia as $item)
	                    <tr>
	                      <td style="text-align: center;">
	                      	{{ $item->diasaldestete}}
	                      </td>
	                      <td style="text-align: center;">
	                        {{ $item->pesoajustadoaldestete}}
	                      </td>
	                      <td style="text-align: center;">
	                      	{{ $item->pesoajustado12m }}
	                      </td>
	                      <td style="text-align: center;">
	                      	{{ $item->pesoajustado18m }}
	                      </td>
	                      <td style="text-align: center;">
	                      	{{ $item->pesoajustado24m }}
	                      </td>
	                      <td style="text-align: center;">
	                      	<a href="{{route('parametros_ganaderia.editar', [$finca->id_finca, $item->id] ) }}" class="btn alert-success btn-sm">
				                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
				                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
				              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
				              </svg> 
				            </a>
	                      </td>
	                    </tr>
	                  </tbody>
	                  @endforeach()
	            	</table>
				</div>
      			</div>
     			<div class="tab-pane" role="tabpanel" id="seccion2">
	     				<form action="{{ route('parametros_reproduccion.crear', $finca->id_finca) }}" method="POST" class="form-trans">
	     				@csrf	
     					<div class="row">
	        				<div class="col-md-6 my-2"> <!-- Col1 -->
	        			@if(session('msj'))
				          <div class="alert alert-success alert-dismissible fade show" role="alert">
				              <strong>¡Felicidades!</strong> {{ session('msj') }}
				            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				            </button>
				          </div>
				        @endif			
								<div class="row my-4">
									<div class="col">
										<label class="col-form-label title-tipo">Días Entre Celos: </label>
										<input 
						              	class="form-control" 
						              	id="diasentrecelo" 
						              	type="number" 
						              	min="0"
						              	max="999"
						              	placeholder="0"
						              	name="diasentrecelo"
						              	value="{{old('$parametrosReproduccion->diasentrecelo') }}"
						              	{!! $contpR>0?"readonly=true":"" !!}>
									</div>
									<div class="col">
										<label class="col-form-label title-tipo">Tiempo de Gestación: </label>
						              	<input 
						              	class="form-control" 
						              	id="tiempogestacion" 
						              	type="number" 
						              	min="0"
						              	max="999"
						              	name="tiempogestacion"
						              	placeholder="0"
						              	value="{{old('$parametrosReproduccion->	tiempogestacion') }}"
						              	{!! $contpR>0?"readonly=true":"" !!}>
									</div>
								</div>
								<div class="row">
									<div class="card-footer clearfix">
										@if($contpR > 0)

				            			@else
							            <button type="submit" class="btn alert-success aling-boton">
							            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
							                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
							            </svg> Registrar</button>
							            @endif
							            <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
							              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
							            </svg> volver</a>
	          						</div>
								</div>
							</div>
							<div class="col-md-6 my-4">
								<table class="table table-striped title-tipo">
				                  <thead>
				                    <tr>
				                      <th style="width: 15%; text-align: center;">Días Entre Celos</th>
				                      <th style="width: 15%; text-align: center;">Tiempo de Gestación (días)</th>
				                      <th style="width: 20%; text-align: center;">Acción</th>
				                    </tr>
				                  </thead>
				                  <tbody>
				                  	@foreach($parametrosReproduccion as $item)
				                    <tr>
				                      <td style="text-align: center;">
				                      	{{ $item->diasentrecelo}}
				                      </td>
				                      <td style="text-align: center;">
				                        {{ $item->tiempogestacion}}
				                      </td>
				                      <td style="text-align: center;">
				                      	<a href="{{route('parametros_reproduccion.editar', [$finca->id_finca, $item->id] ) }}" class="btn alert-success btn-sm">
							                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
							                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
							              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
							              </svg> 
							            </a>
				                      </td>
				                    </tr>
				                  </tbody>
				                  @endforeach()
				            	</table>
							</div>
						</div>
      				  </form>
      				</div>
      				<div class="tab-pane" role="tabpanel" id="seccion3">
      					<form action="{{ route('parametros_produccion_leche.crear', $finca->id_finca) }}" method="POST" class="form-trans">
	     				@csrf	
        				<div class="col-md-12 my-2"> <!-- Col1 -->
        				@if(session('msj'))
				          <div class="alert alert-success alert-dismissible fade show" role="alert">
				              <strong>¡Felicidades!</strong> {{ session('msj') }}
				            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				            </button>
				          </div>
				        @endif
							<div class="row">
								<div class="col">
									<label class="col-form-label title-tipo">Días a ser Secado: </label>
									<input 
					              	class="form-control" 
					              	id="diassecado" 
					              	type="number" 
					              	min="0"
					              	max="999"
					              	placeholder="0"
					              	name="diassecado"
					              	value="{{old('$parametrosProduccion->diassecado') }}"
					              	{!! $contpP>0?"readonly=true":"" !!}>
								</div>
								<div class="col">
									<label class="col-form-label title-tipo">Días de Lactancia Estimada: </label>
					              	<input 
					              	class="form-control" 
					              	id="diaslactanciaestimada" 
					              	type="number" 
					              	min="0"
					              	max="999"
					              	name="diaslactanciaestimada"
					              	placeholder="0"
					              	value="{{old('$parametrosProduccion->diaslactanciaestimada') }}"
					              	{!! $contpP>0?"readonly=true":"" !!}>
								</div>
								<div class="col">
									<label class="col-form-label title-tipo">Días de Producción al Mes: </label>
					              	<input 
					              	class="form-control" 
					              	id="diasproducionalmes" 
					              	type="number" 
					              	min="0"
					              	max="999"
					              	placeholder="0" 
					              	name="diasproducionalmes"
					              	value="{{old('$parametrosProduccion->diasproducionalmes ') }}"
					              	{!! $contpP>0?"readonly=true":"" !!}>	
								</div>
							</div>
							<div class="row my-2">
								<div class="col">
									<label class="col-form-label title-tipo">Lactancia Ajustada (Días):  </label>
					              	<input 
					              	class="form-control" 
					              	id="lactanciaajustada" 
					              	type="number" 
					              	min="0"
					              	max="999"
					              	placeholder="0" 
					              	name="lactanciaajustada"
					              	value="{{old('$parametrosProduccion->lactanciaajustada ') }}"
					              	{!! $contpP>0?"readonly=true":"" !!}>	
								</div>
								<div class="col">
									<label class="col-form-label title-tipo">Litros Promedio por Día:</label>
					              	<input 
					              	class="form-control" 
					              	id="litrospromedioaldia" 
					              	type="number" 
					              	min="0"
					              	max="999"
					              	placeholder="0" 
					              	name="litrospromedioaldia"
					              	value="{{old('$parametrosProduccion->	litrospromedioaldia ') }}"
					              	{!! $contpP>0?"readonly=true":"" !!}>
								</div>
								<div class="col">
									<label class="col-form-label title-tipo">Producción Ideal (Lts): </label>
					              	<input 
					              	class="form-control" 
					              	id="produccionideal" 
					              	type="number" 
					              	min="0"
					              	max="999"
					              	placeholder="0" 
					              	name="produccionideal"
					              	value="{{old('$parametrosProduccion->produccionideal') }}"{!! $contpP>0?"readonly=true":"" !!}>
								</div>
							</div>
							<div class="row">
								<div class="card-footer clearfix">
									@if($contpP > 0)

				            		@else
						            <button type="submit" class="btn alert-success aling-boton">
						            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
						                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
						            </svg> Registrar</button>
						            @endif
						            <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
						              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
						            </svg> volver</a>
          						</div>
							</div>
						</div>
						<div class="col-md-12 my-4">
							<table class="table table-striped title-tipo">
			                  <thead>
			                    <tr>
			                      <th style="width: 15%; text-align: center;">Días a Ser Secado</th>
			                      <th style="width: 15%; text-align: center;">Días de Lactancia Estimada</th>
			                      <th style="width: 15%; text-align: center;">Días de Producción al Mes</th>
			                      <th style="width: 15%; text-align: center;">Lactancia Ajustada (Días)</th>
			                      <th style="width: 15%; text-align: center;">Lts. Promedio al Día</th>
			                      <th style="width: 15%; text-align: center;">Producción Ideal</th>
			                      <th style="width: 20%; text-align: center;">Acción</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                  	@foreach($parametrosProduccion as $item)
			                    <tr>
			                      <td style="text-align: center;">
			                      	{{ $item->diassecado }}
			                      </td>
			                      <td style="text-align: center;">
			                        {{ $item->diaslactanciaestimada }}
			                      </td>
			                      <td style="text-align: center;">
			                      	{{ $item->diasproducionalmes }}
			                      </td>
			                      <td style="text-align: center;">
			                      	{{ $item->lactanciaajustada }}
			                      </td>
			                      <td style="text-align: center;">
			                      	{{ $item->litrospromedioaldia }}
			                      </td>
			                      <td style="text-align: center;">
			                      	{{ $item->produccionideal  }}
			                      </td>
			                      <td style="text-align: center;">
			                      	<a href="{{route('parametros_produccion_leche.editar', [$finca->id_finca, $item->id] ) }}" class="btn alert-success btn-sm">
						                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
						                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
						              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
						              </svg> 
						            </a>
			                      </td>
			                    </tr>
			                  </tbody>
			                  @endforeach()
			            	</table>
						</div>
      					</form>
      				</div>
    			</div>
    		</div>
  		</div>
	</div>
</div><!-- /.container-->	
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
  

@stop
