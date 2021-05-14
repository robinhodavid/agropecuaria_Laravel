@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row my-2">
		<div class="col">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary btn-sm float-right mr-2" title="Crear Trabajo de Campo" alt="Crear Trabajo de Campo" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus"></i>
			</button>
			<a href="{{route('vistacomparar',$finca->id_finca)}}" class="btn alert-success btn-sm float-right mr-2">
		    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
		    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
		    </svg></a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12"> <!-- Col1 -->
			<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title title-header">Lista de Trabajo de Campo</h3>
	               	<form method="GET" action="{{route('inventario', $finca->id_finca) }}" role="search">
	               	 	<div class="card-tools search-table">
	                    <div class="input-group input-group-sm" style="width: 250px;">
	                      <input type="text" name="tc" id="tc" class="form-control float-right" placeholder="Buscar Trabajo de Campo...">
	                        <div class="input-group-append">
	                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
	                        </div>
	                    </div>
	                	</div>
	            	</form>
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
	              	<table class="table table-hover text-nowrap">
	                  	<thead>
		                    <tr>
		                      <th style="width: 30%">Nombre</th>
		                      <th style="width: 10%">F. Inicio</th>
		                      <th style="width: 10%">F. Final</th>
		                      <th style="width: 20%; text-align: center;">Acción</th>
		                    </tr>
	                  	</thead>
		                  	<tbody>
		                  	@foreach($trabajoCampo as $item)
			                    <tr> 	
			                      	<td>
				                       	<a href="{{route('tc.detalle',[$finca->id_finca, $item->id])}}">
				                      		{{ $item->nombre }}
				                        </a>
			                     	</td>
			                      	<td>
			                      		{{ $item->fi }}
			                      	</td>
			                      	<td>
			                      		{{ $item->ff }}
			                      	</td>
		                      	  	<td style="width: 20%; text-align: center;">
			                      		<!--
			                      		<a href="" class="btn alert-success btn-sm">
								    	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
					  					<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
					 					<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
										</svg> </a> -->
							      		<form action="{{ route('tc.eliminar', [$finca->id_finca, $item->id]) }}" class="d-inline form-delete" method="POST">
									    @method('DELETE')
									    @csrf
									    <button type="submit" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
				  						<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
				 						<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
										</svg> </button>
										</form>
					       			</td>
					      		</tr>
		                    @endforeach()
		                  	</tbody>
                	</table>
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix title-header">
	              	{{ $trabajoCampo->links() }}
	              </div>
	        </div>
		</div>
	</div>

<!-- Aquí comienza el modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro Trabajo de Campo</h5>
        @if(session('msj'))
		 	<div class="alert alert-success alert-dismissible fade show" role="alert">
		  		<strong>¡Felicidades!</strong> {{ session('msj') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      	<div class="modal-body">
	        <form action="{{route('tc.crear',$finca->id_finca)}}" method="POST" class = "form-trans">
			 @csrf
			 @error('nombre')
	        	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		            <span>
		              <strong>Atención! </strong>El Campo nombre es obligatorio o <strong>Ya existe.</strong>
		            </span>
		        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		          		<span aria-hidden="true">&times;</span>
		        	</button>
				</div>
			@enderror
			@error('fi')
	        	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		            <span>
		              <strong>Atención! </strong>El Campo Fecha Inicio es obligatorio o <strong>Ya existe.</strong>
		            </span>
		        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		          		<span aria-hidden="true">&times;</span>
		        	</button>
				</div>
			@enderror
			@error('ff')
	        	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		            <span>
		              <strong>Atención! </strong>El Campo Fecha Final es obligatorio o <strong>Ya existe.</strong>
		            </span>
		        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		          		<span aria-hidden="true">&times;</span>
		        	</button>
				</div>
			@enderror
	        <div class="mb-3">
	          	<div class="row">
		          	<div class="col">
		          		<div class="form-group">
			            	<label class="col-form-label">Nombre:</label>
				                <input 
				                class="form-control" 
				                id="nombre" 
				                type="text" 
				                name="nombre"  
				                placeholder="Ingrese Nombre del Trabajo de Campo" 
				                data-role="tagsinput"
				                value="{{ old('nombre') }}">	
	         			</div>
		          	</div>	
	          	</div>
	          	<div class="row">
	          		<div class="col">
		          		<label class="col-form-label form-group title-header">F. Inicio.</label>
						    <div class="input-group mb-3 form-group">
							  	<input 
							  	type="date" 
							  	id="fi"
							  	name="fi"
							  	min="1990-01-01" 
						  		max="2031-12-31"
							  	class="form-control" 
							  	aria-label="fi" aria-describedby="basic-addon2"
							  	value="{{old('fi')}}">
								<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
								<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
								<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
								</svg></span>	
							</div>	
	          		</div>
	          		<div class="col">
	          			<label class="col-form-label form-group title-header">F. Final.</label>
						    <div class="input-group mb-3 form-group">
							  	<input 
							  	type="date" 
							  	id="ff"
							  	name="ff"
							  	min="1990-01-01" 
						  		max="2031-12-31"
							  	class="form-control" 
							  	aria-label="ff" aria-describedby="basic-addon2"
							  	value="{{old('ff')}}">
								<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
								<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
								<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
								</svg></span>	
							</div>		
	          		</div>
	          	</div>
        	</div>
      	</div>
      <div class="modal-footer">
        <button type="button" class="btn bg-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
    		</form>
      </div>
    </div>
  </div>
</div>

<!-- Aqui termina el modal-->

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
    
    {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}
  	{!! Html::script('js/sweetalert2.js')!!}	

    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
	});
    </script>

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
  
      var fecini = new Date(document.getElementById('fi').value);    
      var fecfin = new Date(document.getElementById('ff').value);
      
      if (fecini > fecfin) {
        e.preventDefault();
        Swal.fire({
        text:'La Fecha "Final" no puede ser anterior a la fecha "Inicial" del ciclo',
        icon: 'error',
        title:'¡Rango de Fecha No valido!'
        })
      }
    }); 
	</script>  

    <script>
		var myModal = new bootstrap.Modal(document.getElementById('myModal'), options)

	</script>

@stop
