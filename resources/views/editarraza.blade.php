@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Registro de Raza</h1>
@stop

@section('content')
 
 @if(session('msj'))
 	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong> {{ session('msj') }} </strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
	</div>
 @endif
<div class="container">
	<div class="row my-4">
		<div class="form-registro">
			<form action="{{ route('raza.update', $raza->idraza) }}" method="POST">
				@method('PUT')
				@csrf
				@error('nombreraza')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre de la Raza es obligatorio.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
			  <div class="form-group">
			    <label>Nombre:</label>
				    <input 
				    class="form-control" 
				    id="descripcion" 
				    type="text" 
				    name="descripcion"  
				    placeholder="Ingrese Nombre de la Raza" 
				    value="{{ $raza->descripcion }}">
				 <!--<small id="emailHelp" class="form-text text-muted">Ej. C1 para identficar Condición 1 </small> -->

			    <label>Nomenclatura:</label>
			    <input 
				    class="form-control" 
				    id="nombreraza" 
				    type="text" 
				    name="nombreraza"  
				    placeholder="Sigla o Nomenclatura" 
				    value="{{ $raza->nombreraza }}">
			  </div>
			  <!--<small id="emailHelp" class="form-text text-muted">Ej. BR para identficar raza Brahanma</small>-->
			  <button type="submit" class="btn alert-success">Guardar</button>
			  <a href="{{ route('raza') }}" class="btn btn-warning btn-sm">volver</a>
			</form>
		</div>
	</div>
</div>
@stop

@section('css')
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  
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
