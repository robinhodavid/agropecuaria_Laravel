@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<!-- Aquí comienza el modal Contenido-->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-header" id="exampleModalLabel">Crear Item</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
        <form action="{{route('blocknotasitem.crear')}}" method="POST">
		@csrf
      	<div class="mb-3">
      		<div class="row">
          		<div class="col">
	          		<div class="form-group oculto ">
		            	<label class="col-form-label oculto">id de la Nota</label>
			                <input 
			                class="form-control oculto" 
			                id="iddelanota" 
			                type="text" 
			                name="iddelanota"  
			                data-role="tagsinput"
			                value="{{$blockList->id}}">
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
			                value="{{old('contenido')}}">
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
<!-- Aqui termina el modal Cear Contenido Item-->

<!-- Aquí comienza el modal Editar Contenido-->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title-header" id="exampleModalLabel">Editar Item</h5>
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
        <form action="{{route('blocknotasitem.editar')}}" method="POST">
    	@csrf
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <div class="form-group oculto">
                  <label class="col-form-label oculto">id de la Nota</label>
                      <input 
                      class="form-control oculto" 
                      id="iditemnota" 
                      type="text" 
                      name="iditemnota"  
                      data-role="tagsinput"
                      >
               </div>
                <div class="form-group">
                  <label class="col-form-label">Contenido</label>
                      <input 
                      class="form-control" 
                      id="itemcontent" 
                      type="text" 
                      name="itemcontent"  
                      placeholder="Ingrese item de la nota" 
                      data-role="tagsinput"
                      >
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

<div class="container">
	<div class="row">
		<div class="col column-space">
			
		</div>	
	</div>
	<div class="row">
			<div class="col-md-12"> <!-- Col1 -->
				<div class="card">
		          	<div class="card-header">
		          		<a href="{{ route('blocknotas') }}" class="float-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
			  			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
						</svg> volver</a>
			            	
		              	<div class="card-tools ml-2">
		                  <span data-toggle="tooltip" title="{{$cant}} Notas Pendientes" class="badge badge-danger">{{$cant}}</span>
		                </div>
		                <button type="button" class="btn btn-info float-right btn-sm aling-boton" id="additem" title="Crear Item" alt="Crear Item de Nota" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="fas fa-plus"></i> </button>	
		          	</div>
		            <!-- /.card-header -->
					
					<!-- Aquí el form y todos felices-->
		             <form action="{{route('blocknotasitem.guardar', $blockList->id)}}" method="POST">
    				 @csrf
		            <div class="card-body">
		            	<div class="row">
		            		<h3 class="card-title title-header">
		            			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal" viewBox="0 0 16 16">
								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
								</svg>	{{$blockList->titulo}}
							</h3>	
		            	</div>

		            	@foreach($blockListDetail as $key)	
			            	<ul class="todo-list ui-sortable" data-widget="todo-list">
				                @if($key->id_blocknotas == $blockList->id)
				                  	<li class="">
					                    <!-- checkbox -->				                    
					                    <div class="icheck-primary d-inline ml-2">
					                      <input type="checkbox" value="{{$key->id}}" name="item[]" id="todoCheck1" {!!$key->read?"checked":"" !!}>
					                      <label for="todoCheck1"></label>
					                    </div>
					                    <!-- todo text -->
					                    <span class="text">{{$key->contenido}}</span>
					                    <!-- Emphasis label -->
					                    <small class="badge badge-danger"><i class="far fa-clock"></i> {{ $key->updated_at }} </small>
								        <div class="tools">
								        	<button type="submit" class="btn aling-boton" title="Guardar">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
										  		<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
										  		<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
												</svg>
											</button>
										</form>	

							        	<a href="#" class="btn" id="updateitem" title="Editar Item" alt="Editar Item" data-bs-toggle="modal" data-bs-target="#exampleModal2" onclick="obtenerItem('{{$key->id}}','{{$key->contenido}}');"><i class="fas fa-edit mr-2"> </i>
							        	</a>
				                      	<!-- Colocamos el Boton -->
				                      	<form action="{{ route('blocknotasitem.eliminar', $key->id) }}" class="d-inline form-delete" method="POST" title="Eliminar Item">
										    @method('DELETE')
										    @csrf
										    <button type="submit" class="btn btn-sm"><i class="fas fa-trash"></i> </button>
										</form> 
					                    </div>
				                  	</li>
				                @endif 
				      		</ul>
  						@endforeach()
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

	<!-- Script para los mensajes cuando se va a eliminar--> 
   	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script> 
	
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
