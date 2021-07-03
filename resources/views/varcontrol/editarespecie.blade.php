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
                	 <div class="col title-header">Edición de Especie</div>
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
      					<form action="{{ route ('especie.update', [$especie->id, $finca->id_finca]) }}" method="POST">
			            @method('PUT')
			            @csrf
			            @error('nombre')
			              <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                <strong>Atención!</strong> El nombre de la especie es obligatorio o ya existe.
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                  <span aria-hidden="true">&times;</span>
			                </button>
			              </div>
			            @enderror
			            @error('nomenclatura')
			              <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                <strong>Atención!</strong> El campo nomenclatura es obligatorio.
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                  <span aria-hidden="true">&times;</span>
			                </button>
			              </div>
			            @enderror
            			<div class="form-group">
	                	<label>Especie:</label>
			                <input 
			                class="form-control" 
			                id="nombre" 
			                type="text" 
			                name="nombre"  
			                placeholder="Nombre de Especie" 
			                value="{{ $especie->nombre }}">

	              		<label class="my-2">Nomenclatura:</label>
			                <input 
			                class="form-control" 
			                id="nomenclatura" 
			                type="text" 
			                name="nomenclatura" 
			                placeholder="Nomenclatura" 
			                value="{{ $especie->nomenclatura }}">
           				</div>          
        			</div>
	    		</div><!-- /.card-body -->

	    <div class="card-footer clearfix">
          	<button type="submit" class="btn alert-success aling-boton">
          		<i class="far fa-save"></i>
          	Guardar
            </button>
			<a href="{{ route('especie',$finca->id_finca) }}" class="btn btn-warning aling-boton">	<i class="fas fa-arrow-left"></i> 
			volver
			</a>
			</form>
		</div>
		</div>
		</div> <!-- /.card-footer-->
		
		<div class="col-md-6">
			<div class="card">
	            <div class="card-header">
	                <div class="col title-header">Listado de Especie</div>
	            </div>
	            <!-- /.card-header -->
	            <div class="card-body">
	              	<table class="table table-especie">
				        <thead>
				            <tr>
				              <th scope="col">Especie</th>
				              <th scope="col">Nomenclatura</th>
				            </tr>
				        </thead>
	          			<tbody>
				            <tr>
					            <td>
					                {{ $especie->nombre }}
					            </td>
				                <td>
				                	{{ $especie->nomenclatura }}
				              	</td>
				            </tr>
			            </tbody>
      				</table>
    			</div>
	        </div><!-- /.card-body -->
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
    

@stop
