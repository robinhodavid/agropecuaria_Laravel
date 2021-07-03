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
	                    <th scope="row">Día-Mes-Año</th>
	                    @foreach($periodo as $dt)
	                      <th> {{ $dt->format("d-m-y\n")}}</th>
	                    @endforeach()
	                    </tr>
	                   <!--
	                    <tr>
	                    <th scope="row">Día</th>
	                    @foreach($periodo as $dt)
	                      <th style="text-align: center;"> {{ $dt->format("d\n")}}</th>
	                    @endforeach()

	                    </tr>
	                -->
	                  </thead>
	                  <tbody>
	                    <tr>
	                      <th>Celos</th>
	                    @foreach($historicoTemporada as $item)
		                    <td class="celda color-celo"> 
		                      {!! $item->nrocelo? $item->nrocelo:"" !!}
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
	                    <tr>
	                      <th>Parto No Concluido</th>
	                      	@foreach($historicoTemporada as $item)
	                      <td class="celda color-aborto">
	                      	{!! $item->nropartnc?$item->nropartnc:"" !!}
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
		               		{{-- 
		               		<div class="btn-group dropend">
					            <button type="button" class="btn dropdown-toggle mr-2" data-toggle="dropdown" aria-expanded="false">
					            	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
									  <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
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
				                    <button class="btn dropdown-item" type="submit" name="opcion" value="7">R. Parto No Culminado</button>
			                    </div>
	                		</div>	<!-- /btn-group -->--}}
	                	</div>
                	</div>	
	            </div>
	              <!-- /.card-header -->
	           	<div class="card-body table-responsive p-0" style="height: 300px;">
	            <table class="table table-hover text-nowrap table-head-fixed text-nowrap">
                  	<thead>
	                    <tr>
	                      <th style="width: 10%;">Serie</th>
	                      <th>Sexo</th>
	                      <th>Tipología E.</th>
	                      <th>Tipología S.</th>
	                      <th>Tipología A.</th>
	                      <th>Peso</th>
	                      <th>Acción</th>
	                    </tr>
                 	</thead>
	                <tbody>
	                  	@foreach($seriesparareproduccion as $item)
	                    <tr>
	                    @if($item->id_lotemonta == $monta->id_lotemonta)
	                      <td>{{ $item->serie }}</td>
	                      <td>{!! $item->sexo?"Macho":"Hembra" !!}</td>
	                      <td>{{ $item->nombre_tipologia }}</td>
	                      <td>{{ $item->tipologia_salida }}</td>
	                      <td>{{ $item->tipoactual }}</td>
	                      <td><span class="tag tag-success">{{$item->pesoactual}}</span></td>
	                      <td>	
	                      	@if($temp_reprod->fecdefcierre==null)
	                      		<form action="{{route('seriemonta.eliminar',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie]) }}" class="d-inline form-delete" method="POST">
							              @method('DELETE')
							              @csrf
						              	<button type="submit" class="btn btn-danger btn-sm">
						                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
						                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
						                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
						                  </svg> 
						               	</button>
						            </form> 
	                      	@if ($item->sexo == 0)
		                      	<div class="btn-group dropend">
						            			<button type="button" class="btn dropdown-toggle mr-2" data-toggle="dropdown" aria-expanded="false">
									            	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
													  		<path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
																</svg>
						            			</button>
					                    <div class="dropdown-menu" style="">
					                    	<a class="dropdown-item" href="{{route('celos',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Celo
					                    	</a>
					                    	
						                    <a class="dropdown-item" href="{{route('servicio',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Servicio</a>

						                    <div class="dropdown-divider"></div>
						                    <a class="dropdown-item" href="{{route('palpacion',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Palpaciones</a>
						                      <div class="dropdown-divider"></div>
						                    <a class="dropdown-item" href="{{route('prenez',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Preñez</a>
						                    <a class="dropdown-item" href="{{route('parto',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Parto</a>
						                      <div class="dropdown-divider"></div>
						                    <a class="dropdown-item" href="{{route('aborto',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Aborto</a>
						                    <a class="dropdown-item" href="{{route('partonc',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $item->id_serie ])}}">R. Parto No Culminado</a>
					                    </div>
		                				</div>	<!-- /btn-group -->
	                				@endif()
	                		@endif  
	                		</td>
	                  </tr>
	                    @endif
	                   @endforeach() 
	                </tbody>
	                </table>
	            </div><!-- /.card-body -->
	            <div class="card-footer clearfix">
		            <div class="row">	      	
		         	</div>
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

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	
		{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!}
    {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}
  	{!! Html::script('js/sweetalert2.js')!!}  
  	{!! Html::script('js/routes.js')!!}  

   @if(session('mensaje')=='ok')
      <script>
        Swal.fire({
        title: '¡Eliminado!',
        text:  'Registro Eliminado Satisfacoriamente',
        icon:  'success'
      })
      </script>
  @endif
  @if (session('mensaje')=='info')
      <script>
        Swal.fire({
        text:'El registro no pudeo ser guardado',
        icon: 'error',
        title:'¡Registro no Salvado!'
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
  @if (session('mensaje')=='nop')
      <script>
        Swal.fire({
        text:'No se puede Registrar Preñez a una Serie Preñada',
        icon: 'error',
        title:'¡Registro de Preñez!'
      })
      </script>
  @endif
  @if (session('info')=='ok')
      <script>
        Swal.fire({
        text:'Esta serie no posee registro de preñez. ¡Por favor! Realice un nuevo registro antes de continuar',
        icon: 'info',
        title:'¡No posee Preñez Registrada!'
      })
      </script>
  @endif
  @if (session('info')=='oka')
      <script>
        Swal.fire({
        text:'Esta serie no posee un registro de preñez reciente. ¡Por favor! Realice un nuevo registro antes de continuar',
        icon: 'info',
        title:'¡No posee Preñez Registrada!'
      })
      </script>
  @endif
  @if (session('info')=='int')
   	<script>
        Swal.fire({
        text:'No se puede registrar un parto donde el Tiempo de Preñez Estimada, es menor al Tiempo de Gestación',
        icon: 'info',
        title:'¡Registro de Parto!'
      })
    </script>
  @endif

  @if (session('infoser')=='ok')
      <script>
        Swal.fire({
        text:'Este Registro de Preñez no tiene un Servicio Registrado',
        icon: 'error',
        title:'¡Registro de Preñez Sin Servicio Previo!'
      })
      </script>
  @endif
  
 	@if(session('celos')=='noregistro')
    <script>
      Swal.fire({
        title: '¡Servicio Sin Celos Registrado!',
        text:  'Esta serie no posee registros de celos. ¡Por favor! Realice un nuevo registro de Celos antes de continuar',
       	icon:  'info',               
 	 		})
    </script>
  @endif

  <script>
    $('.form-delete').submit(function(e){
      e.preventDefault();
      Swal.fire({
	      title:'¿Está seguro que desea Retirar la Serie de la Monta?',
	      text:"Este cambio es irreverible",
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Retirar',
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
      var fecus = new Date(document.getElementById('fecus').value);    
      var fecharegistro = new Date(document.getElementById('fecharegistro').value);
      
      if (fecus > fecharegistro) {
        e.preventDefault();
        Swal.fire({
	        text:'La Fecha "Último Servicio" no puede ser posterior a la fecha "Registro" del servicio',
	        icon: 'error',
	        title:'¡Rango de Fecha No valido!'
        })
      }
    }); 
    </script>

@stop
