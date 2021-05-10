@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row my-2">
		<h3 class="title-header">Editar Parámetros de Control</h3>
  		<div class="col"> 
    		<div role="tabpanel">
			    <ul class="nav nav-tabs" role="tablist">
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link active" href="#seccion2" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Reproducción</a>
			      </li>
			    </ul>
    			<div class="tab-content">				
     				<div class="tab-pane active" role="tabpanel" id="seccion2">
	     				<form action="{{ route('parametros_reproduccion.update', [$finca->id_finca, $parametrosReproduccion->id]) }}" method="POST" class="form-trans">
	     				@method('PUT')	
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
					              	value="{{ $parametrosReproduccion->diasentrecelo }}"
					              >
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
					              	value="{{ $parametrosReproduccion->	tiempogestacion }}"
					              	>
								</div>
							</div>
							<div class="row">
								<div class="card-footer clearfix">
						            <button type="submit" class="btn alert-success aling-boton">
						            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
						                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
						            </svg> Guardar</button>
						            
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
				                    </tr>
				                  </thead>
				                  <tbody>
				                    <tr>
				                      <td style="text-align: center;">
				                      	{{ $parametrosReproduccion->diasentrecelo}}
				                      </td>
				                      <td style="text-align: center;">
				                        {{ $parametrosReproduccion->tiempogestacion}}
				                      </td>
				                    </tr>
				                  </tbody>
				            	</table>
							</div>
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
