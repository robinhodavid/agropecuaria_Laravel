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
	                	<h3 class="card-title title-header">Registro de Celos</h3>
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
	              @foreach($series as $item)
	              <div class="card-body">
	              	<div class="row">
              			<div class="col">
              				<label class="col-form-label">Serie:</label>
		                      	<input 
		                      	class="form-control" 
		                      	id="id_serie" 
		                      	type="text" 
		                      	name="ids[]"
		                      	readonly="true" 
		                      	value="{{$item->serie}}">   
              			</div>
	              		<div class="col">
	              				<label class="col-form-label">Fec. Nac.:
								    </label>
						    		<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fnac"
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	readonly="true"
								  	aria-label="fnac" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span></div>
	              		</div>
	              		<div class="col">
	              			<label class="col-form-label">Raza:</label>
		                      	<input 
		                      	class="form-control" 
		                      	id="raza" 
		                      	type="text" 
		                      	name="raza"
		                      	readonly="true"
		                      	value="">   
	              		</div>
	              		<div class="col">
	              			<label class="col-form-label">Fec. Registro:
								    </label>
						    		<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fregistro"
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	aria-label="fnac" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span></div>
	              		</div>
	              		<div class="col">
	              			<label class="col-form-label">Responsable</label>
			                      	<select class="form-select" name="raza" aria-label="select example">
                          			<option value="" selected>Seleccione una opción</option>
                          			
	                          		<option value="">Aqui
	                          		</option>
                          			
                            		</select>  
	              		</div>
	              	</div>
	              	<div class="row">
              			<div class="col">
              				<label class="col-form-label">Intervalo Entre Registro de Celos:</label>
		                      	<input 
		                      	class="form-control" 
		                      	id="ierc" 
		                      	type="text" 
		                      	name="ierc"
		                      	readonly="true" 
		                      	value="">
              			</div>
              			<div class="col">
              				<label class="col-form-label">Intervalo de Días Abiertos:</label>
		                      	<input 
		                      	class="form-control" 
		                      	id="ida" 
		                      	type="text" 
		                      	name="ida"
		                      	readonly="true" 
		                      	value="">
              			</div>
              			<div class="col">
              				<label class="col-form-label">Fec. Próximo Celo:
								    </label>
						    		<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fproxcelo"
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	readonly="true"
								  	aria-label="fnac" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span></div>
              			</div>
	              	</div>
	              </div>
	              <hr>
	              @endforeach()
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


     <script>
    
    $('.form-trans').submit(function(e){
  
      var fecini = new Date(document.getElementById('fecini').value);    
      var fecfin = new Date(document.getElementById('fecfin').value);
      
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
