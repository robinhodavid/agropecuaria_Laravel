@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row my-2">
		<h3 class="title-header">Editando Parámetros de Control</h3>
  		<div class="col"> 
    		<div role="tabpanel">
			    <ul class="nav nav-tabs" role="tablist">
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Ganadería</a>
			      </li>
			    </ul>
    			<div class="tab-content">
      			<div class="tab-pane active" role="tabpanel" id="seccion1">
      				<form action="{{ route('parametros_ganaderia.update', [$finca->id_finca,$parametrosGanaderia->id]) }}" method="POST" class="form-trans">
      				@method('PUT')	
        			@csrf
      					<div class="col-md-12 my-2"> <!-- Col1 -->
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
							<label class="col-form-label title-tipo">Días al Destete: </label>
							<input 
			              	class="form-control" 
			              	id="diasaldestete" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0"
			              	name="diasaldestete"
			              	value="{{$parametrosGanaderia->diasaldestete }}"
			              	>
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado al Destete: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajustdestete" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	name="pajustdestete"
			              	placeholder="0"
			              	value="{{$parametrosGanaderia->pesoajustadoaldestete}}"
			              	>
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado 12 meses: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajust12m" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0" 
			              	name="pajust12m"
			              	value="{{ $parametrosGanaderia->pesoajustado12m }}"
			              	>	
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado 18 meses: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajust18m" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0" 
			              	name="pajust18m"
			              	value="{{ $parametrosGanaderia->pesoajustado18m }}"
			              	>	
						</div>
						<div class="col">
							<label class="col-form-label title-tipo">Peso Ajustado 24 meses: </label>
			              	<input 
			              	class="form-control" 
			              	id="pajust24m" 
			              	type="number" 
			              	min="0"
			              	max="999"
			              	placeholder="0" 
			              	name="pajust24m"
			              	value="{{$parametrosGanaderia->pesoajustado24m }}"
			              	>
						</div>
					</div>
					<div class="row">
						<div class="card-footer clearfix">
				            <button type="submit" class="btn alert-success aling-boton">
				            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
			              	<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
			              	<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
			            	</svg> Guardar</button>
				           
				            <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
				              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
				            </svg> volver</a>
  						</div>
					</div>
				</div>
				</form>	
				<div class="col-md-12 my-4">
					<table class="table table-striped title-tipo">
	                  <thead>
	                    <tr>
	                      <th style="width: 15%; text-align: center;">Días al Destete</th>
	                      <th style="width: 15%; text-align: center;">PA al Destete (días)</th>
	                      <th style="width: 15%; text-align: center;">PA 12m (días)</th>
	                      <th style="width: 15%; text-align: center;">PA 18m (días)</th>
	                      <th style="width: 15%; text-align: center;">PA 24m (días)</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <tr>
	                      <td style="text-align: center;">
	                      	{{ $parametrosGanaderia->diasaldestete}}
	                      </td>
	                      <td style="text-align: center;">
	                        {{ $parametrosGanaderia->pesoajustadoaldestete}}
	                      </td>
	                      <td style="text-align: center;">
	                      	{{ $parametrosGanaderia->pesoajustado12m }}
	                      </td>
	                      <td style="text-align: center;">
	                      	{{ $parametrosGanaderia->pesoajustado18m }}
	                      </td>
	                      <td style="text-align: center;">
	                      	{{ $parametrosGanaderia->pesoajustado24m }}
	                      </td>
	                    </tr>
	                  </tbody>
	            	</table>
				</div>
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
