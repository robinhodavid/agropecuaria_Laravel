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
	                	<h3 class="card-title title-header">Temporada de Reproducción</h3>
	              	</div>
	              	<form action="" method="POST" class="form-trans">
					@csrf
	              	@if(session('msj'))
		 			<div class="alert alert-success alert-dismissible fade show" role="alert">
				  		<strong>¡Felicidades!</strong> {{ session('msj') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
		 			@endif
		 			@error('nombre')
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
						  <strong>Atención!</strong> El nombre de la Temporada es obligatorio o ya existe.
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					@enderror
					@error('fecini')
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
						  <strong>Atención!</strong> La fecha Inicial es Requerida.
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					@enderror
	              <!-- /.card-header -->
	              <div class="card-body">
	              	<div class="row">
	              		<div class="form-group">
	              			<label>Nombre de Temporada Reproductiva:</label>
							    <input 
							    class="form-control" 
							    id="nombre" 
							    type="text" 
							    name="nombre"  
							    placeholder="Ingrese nombre de temporada Reproductiva" 
							    value="{{ old('nombre') }}">
						</div>    
		              		<div class="col">
		              		<label class="col-form-label">F. Inicial.</label>
						    	<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	id="fecini"
								  	name="fecini"
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	aria-label="fecini" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>	
								</div>	
		              		</div>
		              		<div class="col">
		              		<label class="col-form-label">F. Final.</label>
						    	<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fecfin"
								  	id="fecfin"
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	aria-label="fecfin" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>	
								</div>		
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
	        </div>
		</div>
				<div class="col-md-12">
			<div class="card">
	              <div class="card-header">
	                <h3 class="card-title title-header">Listado Temporada de Reproducción</h3>
	              <form method="GET" action="{{route('temporada_monta',$finca->id_finca) }}" role="search">
	               	 	<div class="card-tools search-table">
	                    <div class="input-group input-group-sm" style="width: 185px;">
	                      <input type="text" name="temporada" id="temporada" class="form-control float-right" placeholder="Buscar Temporada...">
	                        <div class="input-group-append">
	                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
	                        </div>
	                    </div>
	                	</div>
	              	</form>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	              	<table class="table table-especie">
		  			<thead>
					    <tr>
					    
					      <th scope="col" style="width: 40%; font-weight: 700">Nombre de Temporada</th>
					      <th scope="col" style="width: 15%;">F. Inicial</th>
					      <th scope="col" style="width: 15%;">F. Ap. Cierre</th>
					      <th scope="col" style="width: 15%;">F. Def. Cierre</th>
					      <th scope="col" style="width: 15%;">Acción</th>
					    </tr>
		  			</thead>
		  			<tbody>
	  			@foreach($temp_reprod as $item)
		    		<tr>
				      <td>
				      	<a href="{{ route ('temporada.detalle', [$finca->id_finca, $item->id])}}">
				      		{{ $item->nombre }}
				      	</a>
				      </td>
				        <td>
				      	{{ $item->fecini }}
				      </td>
				      <td>
				      	{{ $item->fecfin }}	
				      </td>
				       <td>
				      	{{ $item->fecdefcierre }}
				      </td>
				      <td>
				      	<a href="{{ route ('temporada.editar',[$finca->id_finca, $item->id]) }}" class="btn alert-success btn-sm">
				    	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
	  					<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
	 					<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
						</svg> </a>
				      	<form action="{{ route('temporada.eliminar',[$finca->id_finca, $item->id]) }}" class="d-inline form-delete" method="POST">
						    @method('DELETE')
						    @csrf
						    <button type="submit" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
	  						<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
	 						<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
							</svg> </button>
						</form> 
						<form action="{{ route('temporada.cerrar',[$finca->id_finca, $item->id]) }}" class="d-inline form-cierre" method="POST">
							@method('PUT')
						    @csrf
						    @if( empty($item->fecdefcierre) )
						    	<button type="submit" class="btn btn-secondary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
								<path d="M7.5 1v7h1V1h-1z"/>
								<path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
								</svg></button>
							@else
								<button type="submit" class="btn btn-secondary btn-sm" disabled="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
								<path d="M7.5 1v7h1V1h-1z"/>
								<path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
								</svg></button>
							@endif()		
						</form> 
				      </td>
				    </tr>
				@endforeach()
	  			</tbody>
			</table>

	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	              	{{ $temp_reprod->links() }}
	              </div>
	        </div> <!--Col2 -->
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
  	{!! Html::script('js/sweetalert2.js')!!}	
    
  	@if(session('mensaje')=='ok')
	  	<script>
	  		Swal.fire({
				title: '¡Eliminado!',
				text:  'Registro Eliminado Satisfactoriamente',
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
    
    $('.form-cierre').submit(function(e){
    	e.preventDefault();
	    Swal.fire({
			title:'¿Está seguro que desea realizar el cierre Definitivo de la Temporada',
			text:"Este cambio es irreverible",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Cerrar',
			cancelButtonText: 'Cancelar'
		}).then((result)=>{
			if (result.value){
				this.submit();
			}
		})
    });	
    </script>

    @if(session('msje')=='ok')
	  	<script>
	  		Swal.fire({
				title: '¡Cierre de Temporada!',
				text:  'Temporada Cerrada Satisfactoriamente',
				icon:  'success'
			})
	  	</script>
	@endif
	@if (session('msje')=='error')
	  	<script>
	  		Swal.fire({
				text:'Está siendo usado por otro recurso',
				icon: 'error',
				title:'¡Temporada no cerrada!'
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
  
      var fecini = new Date(document.getElementById('fecini').value);    
      var fecfin = new Date(document.getElementById('fecfin').value);
      
      if (fecini > fecfin) {
        e.preventDefault();
        Swal.fire({
        text:'La Fecha "Final" no puede ser anterior a la fecha "Inicial" de la Temporada',
        icon: 'error',
        title:'¡Rango de Fecha No valido!'
        })
      }
    }); 
	</script>  

@stop
