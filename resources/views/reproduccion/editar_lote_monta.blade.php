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
	                	<h3 class="card-title title-header">Lote de Monta</h3>
	              	</div>
	              	@if(session('msj'))
		 			<div class="alert alert-success alert-dismissible fade show" role="alert">
				  		<strong>¡Felicidades!</strong> {{ session('msj') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
		 			@endif
		 			<form action="{{ route('lotemonta.editar', [$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $lotemonta->id_lotemonta] ) }}" method="POST">
		 			@method('PUT')
				    @csrf
		 			@error('lote')
				        <div class="alert alert-warning alert-dismissible fade show" role="alert">
		                  <strong>Atención!</strong> El campo nombre Lote de Monta es requerido o ya existe.
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
				    @enderror
	              <!-- /.card-header -->
	              <div class="card-body">
	              	<div class="row">
	              		<div class="col">
		              		<div class="form-group">
		              			<label class="col-form-label">Lote de Monta</label>
					                <select class="form-select" name="lote" 
					                        id="lote" aria-label="select example">
					                  <option value="{{$lotemonta->id_lote}}" selected>{{$lotemonta->nombre_lote}}</option>
					                  
					                  <!-- Nos permite cargar el Select con otras opciones -->
					                  @foreach($lote as $item)
					                    <option value="{{ $item->id_lote}}">{{ $item->nombre_lote}}</option>
					                  @endforeach()
					                </select>  
							</div> 
	              		</div>
	              		<div class="col">
	              			<div class="form-group">
		              			<label class="col-form-label">Sublote de Monta</label>
				                <select class="form-select" name="sublote" 
				                  id="sexo" aria-label="select example">

				                  @if(! empty($lotemonta->sub_lote) )
				                  	<option value="{{$lotemonta->sub_lote}}" selected>{{$lotemonta->sub_lote}}</option>
				                  @else
				                  	<option value=" " selected>Este Lote no posee Sublote</option>
				                  @endif
				                  

				                  <!--Para agregar mas opciones -->
				                    @foreach($sublote as $item)
				                      <option value="{{ $item->sub_lote}}">{{ $item->sub_lote}}</option>
				                    @endforeach()
				                </select> 
	                        </div>  	
	              		</div>
	              	</div>
	              	<div class="row">	
						<div class="col">
							<label class="col-form-label form-group">F. Inicial.</label>
						    	<div class="input-group mb-3 form-group">
								  	<input 
								  	type="date" 
								  	id="fechainicialciclo"
								  	name="fechainicialciclo"
								  	min="{{$temp_reprod->fecini}}" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	aria-label="fechainicialciclo" aria-describedby="basic-addon2"
								  	readonly="true"
								  	value="{{$temp_reprod->fecini}}">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>	
								</div>	
						</div>
						<div class="col">
						<label class="col-form-label">F. Final.</label>
						    	<div class="input-group mb-3">
								  	<input 
								  	type="date" 
								  	name="fechafinalciclo"
								  	id="fechafinalciclo"
								  	min="{{$temp_reprod->fecini}}" 
							  		max="2031-12-31"
								  	class="form-control" 
								  	readonly="true" 
								  	value="{{$fechafin}}"
								  	aria-label="fechafinalciclo" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>	
								</div>		
						</div> 
						<div class="col">
		              		<label class="col-form-label">Duración (M-D)</label>
							    <input 
							    class="form-control" 
							    id="duracion" 
							    type="text" 
							    name="duracion"  
							    placeholder="(M-D)" 
							    readonly="true" 
							    value="{{ $duracion }}">
		              	</div>	              	  
	              	</div>

	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	              	<button type="submit" class="btn alert-success aling-boton">
			            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
			                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
			            </svg> Guardar</button>

            		<a href="{{ route('lotemonta.crear',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo]) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
              		<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            		</svg> volver</a>
          		</form>


	              </div>
	        </div>
		</div>
		<div class="col-md-12">
			<div class="card">
	              <div class="card-header">
	                <h3 class="card-title title-header">Listado de Lotes de Montas</h3>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	              	<table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="width: 10%">Lote</th>
                      <th style="width: 10%">Sublote</th>
                      <th style="width: 10%">F. Inicial</th>
                      <th style="width: 10%">F. Final</th>
                      <th style="width: 10%">A. Inicial</th>
                      <th style="width: 10%">A. Final</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 10%">
                      {{ $lotemonta->nombre_lote }}
                      </td>
                      <td>
                      	{{ $lotemonta->sub_lote }}
                      </td>
                       <td style="width: 10%; text-align: center;">
                		{{ $lotemonta->fechainirea}}
                      </td>
                      <td style="width: 10%; text-align: center;">
                     	{{ $lotemonta->fechafinrea}}
                      </td>
                      <td>
                     	{{ $lotemonta->anho1}}
                      </td>
                      <td>
                     	{{ $lotemonta->anho2}}
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

@stop
