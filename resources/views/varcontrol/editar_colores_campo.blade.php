@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-6"> <!-- Col1 -->
			<div class="card">
	              	<div class="card-header">
	                	<div class="col title-header">Editar Color de Campo</div>
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
	            		<div class="form-registro">
          					<form action="{{ route ('colores.update',[ $finca->id_finca, $colores->id]) }}" method="POST">
          					@method('PUT')	
				            @csrf
				            @error('nombre')
			                <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                  <strong>Atención!</strong> El campo Nombre es obligatorio o ya existe.
			                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                      <span aria-hidden="true">&times;</span>
			                    </button>
			                </div>
			                @enderror
                			<div class="row">
                  				<div class="col">
				                    <div class="form-group">
				                      <label>Nombre:</label>
				                          <input 
				                          class="form-control" 
				                          id="nombre" 
				                          type="text" 
				                          name="nombre"  
				                          placeholder="Ingrese el Nombre" 
				                          value="{{ $colores->nombre }}">
				                    </div>
                  				</div>
               				</div>
                		</div>            
        			</div>          	
	              	<!-- /.card-body -->
	              	<div class="card-footer clearfix">
	              	  <button type="submit" class="btn alert-success aling-boton">
			            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
		              	<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
		              	<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
		            	</svg> Guardar
		            </button>
            		<a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
          			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
        			</svg> 
        			volver</a>
         			</form>
	            	</div>
	        </div>
		</div>

		<div class="col-md-6">
			<div class="card">
	           	<div class="card-header">
	                <div class="col title-header border-bottom">Listado Colores de Campo </div>
	            </div>
	            <!-- /.card-header -->
	            <div class="card-body">
	            	<table class="table table-especie">
			          	<thead>
				            <tr>
				              <th scope="col">Nombre</th>
				            </tr>
			          	</thead>
          				<tbody>
            				<tr>
				                <td>
				                  {{ $colores->nombre}}
				                </td>
           					</tr>
         			</tbody>
     			 </table>
	            </div>
	            <!-- /.card-body -->
	            <div class="card-footer clearfix">
	               
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
