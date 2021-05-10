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
	                	<h3 class="card-title title-header">Editando Registro de Celos</h3>
	              	</div>
	              	@if(session('msj'))
		 			<div class="alert alert-success alert-dismissible fade show" role="alert">
				  		<strong>¡Felicidades!</strong> {{ session('msj') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
		 			@endif
		 			<form action="{{route('celos.update',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id, $celos->id]) }}" method="POST">
		 			@method('PUT')
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
			                      	value="{{$celos->id_serie}}">   
	              			</div>
	              			<div class="col oculto">
	              				<label class="col-form-label oculto">dec:</label>
			                      	<input 
			                      	class="form-control oculto" 
			                      	id="dec" 
			                      	type="number" 
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
			                      	value="{{$celos->serie}}">   
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
									  	aria-label="fnac" aria-describedby="basic-addon2">
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
									  	value="{{$celos->fechr}}"
									  	aria-label="fregistro" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
		              		</div>
		              		<div class="col">
		              			<label class="col-form-label">Responsable</label>
				                <select class="form-select" name="resp" id="resp" aria-label="select example">
	                          		<option value="{{$celos->resp }}" selected>{{$celos->resp }}</option>
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
			                      	value="{{$celos->dias}}">
	              			</div>
	              			<div class="col">
	              				<label class="col-form-label">Intervalo de Días Abiertos:</label>
			                      	<input 
			                      	class="form-control" 
			                      	id="ida" 
			                      	type="text" 
			                      	name="ida"
			                      	readonly="true" 
			                      	value="{{$celos->intdiaabi}}">
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
									  	value="{{$celos->fecestprocel}}"
									  	aria-label="fnac" aria-describedby="basic-addon2">
										<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
										<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
										<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
										</svg></span></div>
	              			</div>
		              	</div>
		              	<hr>
	              </div>
	             
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	              	<button type="submit" class="btn alert-success aling-boton">
			        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16"><path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/><path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/></svg>  Guardar</button>
			        <a href="{{route('celos',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id, $celos->id ])}}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
			          <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
			        </svg> volver</a>
	              </div>
	        </div>
		</div>

		<div class="col-md-12"> <!-- Col1 -->
			<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title title-header">Lista de Celos Registrados</h3>
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
	              <table class="table">
				        <thead>
				            <tr>
				              <th scope="col">Serie</th>
				              <th scope="col">F. Registro</th>
				              <th scope="col">Responsable</th>
				              <th scope="col">IERC</th>
				              <th scope="col">IDA</th>
				              <th scope="col">F. Próx Celo</th>
				            </tr>
				        </thead>
          				<tbody>
		            		<tr>
				              <td>
				                {{ $celos->serie }}
				              </td>
				              <td>
				                {{ $celos->fechr }}
				              </td>
				              <td>
				                {{ $celos->resp }}
				              </td>
				              <td>
				                {{ $celos->dias }}
				              </td>
				               <td>
				                {{ $celos->intdiaabi }}
				              </td>
				              <td>
				                {{ $celos->fecestprocel }}
				              </td>
		            		</tr>
	          			</tbody>
	      			</table>	
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
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
