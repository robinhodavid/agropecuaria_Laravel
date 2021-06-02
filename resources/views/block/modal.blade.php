@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">

<!-- Aquí comienza el modal Contenido-->

<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-header" id="exampleModalLabel">Crear Item</h5>
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
        <form action="#" method="POST">
		@csrf
		@error('contenido')
        	<div class="alert alert-warning alert-dismissible fade show" role="alert">
	            <span>
	              <strong>Atención! El Contenido de la Nota es Requerido</strong>
	            </span>
	        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
			</div>
		@enderror
          <div class="mb-3">
          	<div class="row">
	          	<div class="col">
	          		<div class="form-group oculto">
		            	<label class="col-form-label oculto">id de la Nota</label>
			                <input 
			                class="form-control oculto" 
			                id="iddelanota" 
			                type="text" 
			                name="iddelanota"  
			                data-role="tagsinput"
			                value="{{$blockListDetail->id}}">
         			 </div>
	          		<div class="form-group">
		            	<label class="col-form-label">Contenido</label>
			                <input 
			                class="form-control" 
			                id="contenido" 
			                type="text" 
			                name="contenido"  
			                placeholder="Ingrese item de la nota" 
			                data-role="tagsinput"
			                value="{{$blockListDetail->contenido}}">
         			 </div>
	          	</div>	
          	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

	{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!} 
	{!! Html::script('js/jquery-3.5.1.min.js')!!}
    {!! Html::script('js/metodos.js')!!}
    {!! Html::script('js/sweetalert2.js')!!} 

    <script> console.log('Hi!'); </script>
    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
});
    </script>
    <script>
		var myModal = new bootstrap.Modal(document.getElementById('myModal'), options)
	</script>

@stop





