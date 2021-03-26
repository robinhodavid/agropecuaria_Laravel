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
	                <h3 class="card-title title-header">Progreso de Temporada - Monta Tipo: {{$ciclo->tipomonta}} </h3>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body table-responsive p-0">
	                <table class="table table-hover text-nowrap">
	                  <thead>
	                  	<tr>
	                    <th scope="row">Mes-Año</th>
	                    @foreach($periodo as $dt)
	                      <th> {{ $dt->format("m-Y\n")}}</th>
	                    @endforeach()
	                    </tr>
	                    <tr>
	                    <th scope="row">Día</th>
	                    @foreach($periodo as $dt)
	                      <th style="text-align: center;"> {{ $dt->format("d\n")}}</th>
	                    @endforeach()
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <tr>
	                      <th>Celos</th>
			                @foreach($historicoTemporada as $item)
			                    <td class="celda color-celo"> 
			                      {!! $item->nrocelo?$item->nrocelo:"" !!}
			                    </td>
		                    @endforeach()
	                    </tr>
	                    <tr>
	                      <th>Servicios</th>
	                      @foreach($historicoTemporada as $item)
	                      <td class="celda color-servicios">
	                      		{!! $item->nroservicio? $item->nroservicio:"" !!}
	                      </td>
	                       	@endforeach()
	                    </tr>
	                    <tr>
	                    	<th>Palpaciones</th>
		                    	@foreach($historicoTemporada as $item)
			                      <td class="celda color-palpaciones">
			                      	{!! $item->nropalpa?$item->nropalpa:"" !!}
			                      </td>
		                       	@endforeach()
	                    </tr>
	                    <tr>
	                      <th>Preñez</th>
	                      @foreach($historicoTemporada as $item)
	                      <td class="celda color-prenhez">
	                      	{!! $item->nropre?$item->nropre:"" !!}
	                      </td>
	                       	@endforeach()
	                    </tr>
	                    <tr>
	                      <th>Parto</th>
		                    @foreach($historicoTemporada as $item)
			                    <td class="celda color-parto">
			                      	{!! $item->nropart?$item->nropart:"" !!}
			                    </td>
	                       	@endforeach()
	                    </tr>
	                    <tr>
	                      <th>Aborto</th>
	                      	@foreach($historicoTemporada as $item)
	                      <td class="celda color-aborto">
	                      	{!! $item->nroabort?$item->nroabort:"" !!}
	                      </td>
	                       	@endforeach()
	                    </tr>
	                  </tbody>
	                </table>
	              </div>
	              <!-- /.card-body -->
	            </div>
			</div>
	</div>

@foreach($lotemonta as $monta)
	<div class="row">
		<div class="col-md-12"> <!-- Col1 -->
			<div class="card">
				<form action="{{route('registros.formulario',[$finca->id_finca, $temp_reprod->id,$ciclo->id_ciclo]) }}" method="POST">
	            @csrf
	            @error('id')
	              <div class="alert alert-warning alert-dismissible fade show" role="alert">
	                <span>
	                  <strong>¡Atención! </strong>Debe seleccionar al menos un Nro. de Serie.
	                </span>
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                  <span aria-hidden="true">&times;</span>
	                </button>
	              </div>
	            @enderror
	            <div class="card-header">
	            	<div class="row">
		            	<div class="col-9">
		               		<h3 class="card-title title-header">Lote de Monta: {{$monta->nombre_lote}}</h3>
		               	</div>
		               	<div class="col-3" style="text-align: end;">
		               		<div class="btn-group dropend">
					            <button type="button" class="btn btn-primary dropdown-toggle mr-2" data-toggle="dropdown" aria-expanded="false">
					            	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
									<path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
									</svg>
					            </button>
			                    <div class="dropdown-menu" style="">
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="1">R. Celo</button>
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="2" data-bs-toggle="modal" data-bs-target="#exampleModal">R. Servicio</button>
				                      <div class="dropdown-divider"></div>
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="3">R. Palpaciones</button>
				                      <div class="dropdown-divider"></div>
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="4">R. Preñez</button>
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="5">R. Parto</button>
				                      <div class="dropdown-divider"></div>
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="6">R. Aborto</button>
			                    </div>
	                		</div>	<!-- /btn-group -->
	                	</div>
                	</div>	
	            </div>
	              <!-- /.card-header -->
	           	<div class="card-body table-responsive p-0" style="height: 300px;">
	            <table class="table table-hover text-nowrap table-head-fixed text-nowrap">
                  	<thead>
	                    <tr>
	                      <th>#</th>
	                      <th>Serie</th>
	                      <th>Sexo</th>
	                      <th>Tipología E.</th>
	                      <th>Peso</th>
	                    </tr>
                 	</thead>
	                <tbody>
	                  	@foreach($seriesparareproduccion as $item)
	                    <tr>
	                    @if($item->id_lotemonta == $monta->id_lotemonta)
	                    	<td>
	                    	@if ($item->sexo == 0)
	                          <div class="form-check">        
	                                <input 
	                                class="form-check-input" 
	                                type="checkbox" 
	                                value="{{ $item->id}}" id="id_serie"
	                                name="ids[]">
	                          </div>
	                          @endif()  
	                        </td>
	                      <td>{{ $item->serie }}</td>
	                      <td>{!! $item->sexo?"Macho":"Hembra" !!}</td>
	                      <td>{{ $item->tipo }}</td>
	                      <td><span class="tag tag-success">{{$item->pesoactual}}</span></td>
	                    </tr>
	                    @endif
	                   @endforeach() 
	                </tbody>
	                </table>
	            </div><!-- /.card-body -->
	            <div class="card-footer clearfix">
		            <div class="row">	      	
		         	</div>
		         </form>	
				</div>
	        </div>
		</div>	
	</div>	
@endforeach()
 

 
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
	
	{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!}
    {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}
  
    

@stop
