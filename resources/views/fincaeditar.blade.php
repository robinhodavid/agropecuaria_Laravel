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
                	<h3 class="card-title title-header">Registro de Finca</h3>
              	</div>
              	<form action="{{ route('fincas.update', $fincas->id_finca) }}" method="POST">
				@method('PUT')
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
					  <strong>Atención!</strong> El nombre de la Finca es obligatorio o ya existe.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
                <!-- /.card-header -->
              	<div class="card-body">
              		<div class="form-registro">
					 	<div class="form-group">
						<label>Nombre de la Finca:</label>
						    <input 
						    class="form-control" 
						    id="nombrefinca" 
						    type="text" 
						    name="nombre"  
						    placeholder="Ingrese nombre de la Finca" 
						    value="{{ old('nombre', $fincas->nombre) }}">

					    <label class="my-2">Propósito de Finca:</label>
						    <input 
						    class="form-control" 
						    id="especiefinca" 
						    type="text" 
						    name="especie" 
						    placeholder="Propósito de la Finca" 
						    value="{{ old('especie',$fincas->especie) }}">
						<label class="col-form-label oculto">slug:</label>
						    <input 
						    class="form-control oculto" 
						    id="slug" 
						    type="text" 
						    name="slug"  
						    placeholder="slug"
						    value="{{ old('slug',$fincas->slug) }}">
					  </div>
				</div>
              	</div>
          		<!-- /.card-body -->
          		<div class="card-footer clearfix">
          			<button type="submit" class="btn alert-success aling-boton">
						<i class="far fa-save"></i> Guardar</button>
						<a href="{{ route('home') }}" class="btn btn-warning aling-boton"><i class="fas fa-arrow-left"></i> volver</a>  
				</form>
          		</div>
	        </div>
		</div>
		<div class="col-md-6">
			<div class="card">
              	<div class="card-header">
                	<h3 class="card-title title-header">Listado de Fincas</h3>
              	</div>
              	<!-- /.card-header -->
              	<div class="card-body">
	              	<table class="table table-especie">
			  			<thead>
						    <tr>
						      <th scope="col">Id</th>
						      <th scope="col">Nombre de Finca</th>
						      <th scope="col">Propósito</th>
						      <th scope="col"></th>
						    </tr>
			  			</thead>
			  			<tbody>
				    		<tr>
						      <th scope="row">
						      	{{ $fincas->id_finca }}
						      </th>
						      <td>
						      	{{ $fincas->nombre }}
						      </td>
						        <td>
						      	{{ $fincas->especie }}
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
