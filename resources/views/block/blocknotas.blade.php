@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row my-2">
		<div class="col column-space">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary float-right mr-2" title="Crear Lote" alt="Crear Nota" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus"></i> Crear Nota
			</button>
		</div>
	</div>
	<div class="row">
		@foreach($blockList as $item)
			<div class="col-md-6"> <!-- Col1 -->
				<div class="card">
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
		          	<div class="card-header">
		            	<a href="{{ route('blocknotas.editar', $item->id) }}" class="">
			            	<h3 class="card-title title-header"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal" viewBox="0 0 16 16">
							<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
							<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
							</svg>	{{$item->titulo}}</h3>
						</a>
		              	
		                <div class="card-tools">
		                	@foreach($countDetail as $key)
                      			@if($item->id == $key->id)
                      		<span data-toggle="tooltip" title="{{$item->cant}} Notas Pendientes" class="badge badge-danger"> {{$key->cant}}</span>
                      			@endif	
                      		@endforeach()
                    	</div>
                    	
		          	</div>
		            <!-- /.card-header -->
		            <div class="card-body">
		            	@foreach($blockListDetail as $key)	
			            	<ul class="todo-list ui-sortable" data-widget="todo-list">
				                @if($key->id_blocknotas == $item->id)
				                  	<li class="">
					                    <!-- checkbox -->				                    
					                    <div class="icheck-primary d-inline ml-2">
					                      <input type="checkbox" value="" name="item" id="todoCheck1" disabled="true" {!!$key->read?"checked":"" !!}>
					                      <label for="todoCheck1"></label>
					                    </div>
					                    <!-- todo text -->
					                    <span class="text">{{$key->contenido}}</span>
				                  	</li>
				                @endif 
			          		</ul>
		          		@endforeach()
		            </div>
		            <!-- /.card-body -->
		            <div class="card-footer clearfix">
		            	<form action="{{ route('blocknotas.eliminar', $item->id) }}" class="d-inline form-delete" method="POST">
						  @method('DELETE')
						    @csrf
						    <button type="submit" class="btn btn-default btn-sm aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
	  						<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
	 						<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
							</svg> </button>
						</form>	
		            </div>
		        </div>
			</div>
		@endforeach()
	</div>
</div>

<!-- Aquí comienza el modal Titulo-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-header" id="exampleModalLabel">Crear Nota</h5>
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
         <form action="{{route('blocknotas.crear')}} " method="POST">
		 @csrf
		 @error('titulo')
        	<div class="alert alert-warning alert-dismissible fade show" role="alert">
	            <span>
	              <strong>Atención! El título de la Nota es Requerido</strong>
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
		            	<label class="col-form-label">Título de la Nota</label>
			                <input 
			                class="form-control" 
			                id="titulo" 
			                type="text" 
			                name="titulo"  
			                placeholder="Ingrese título de la nota" 
			                data-role="tagsinput"
			                value="{{old('titulo')}}">
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

	<!-- Script para los mensajes cuando se va a eliminar--> 
   	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script> 
	
    <script type="text/javascript">
    	$(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
        $(".alert-dismissible").alert('close');
		});
    </script>
    
    {!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!} 
	{!! Html::script('js/jquery-3.5.1.min.js')!!}
    {!! Html::script('js/metodos.js') !!}
    {!! Html::script('js/sweetalert2.js') !!} 

   
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
			text:"Este cambio es irreverible, borrará el registros y el contenido asociado al mismo",
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
		var myModal = new bootstrap.Modal(document.getElementById('myModal'), options)
	</script>
 
@stop
