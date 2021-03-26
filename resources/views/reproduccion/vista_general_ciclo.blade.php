@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
<div class="row my-2">
	<div class="col">
		<a href="{{ route('ciclo',[$finca->id_finca, $temp_reprod->id]) }}" class="btn btn-success float-right mr-2" title="Crear Ciclo" alt="Crear Ciclo"><i class="fas fa-plus"></i></a>
	</div>
</div>
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title title-header">Ciclos de Reproducción</h3>
                <form method="GET" action="{{route('temporada.detalle', [$finca->id_finca, $temp_reprod->id]) }}" role="search">
               	 	<div class="card-tools search-table">
                    <div class="input-group input-group-sm" style="width: 250px;">
                      <input type="text" name="ciclo" id="ciclo" class="form-control float-right" placeholder="Buscar Ciclo...">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                	</div>
	            </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="width: 30%">Ciclo</th>
                      <th style="width: 10%">F. Inicial</th>
                      <th style="width: 10%">F. Final</th>
                      <th style="width: 10%; text-align: center;">Duración (M-D)</th>
                      <th style="width: 10%;">Tipo de Monta</th>
                      <th style="width: 20%; text-align: center;">Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@foreach($ciclo as $item)
	                    <tr> 	
	                      <td>
	                       	<a href=" {{route('ciclo.detalle',[$finca->id_finca , $temp_reprod->id, $item->id_ciclo]) }}">
	                      		{{ $item->ciclo }}
	                        </a>
	                      </td>
	                     
	                      <td>
	                      	{{ $item->fechainicialciclo }}
	                      </td>
	                      <td>
	                      	{{ $item->fechafinalciclo }}
	                      </td>
	                      <td style="width: 10%; text-align: center;">
	                      	{{ $item->duracion }}
	                      </td>
                         <td>
                          {{ $item->nombre }}
                        </td>
                      <td style="width: 20%; text-align: center;">
                      	<a href=" {{ route ('serieslotemonta',[$finca->id_finca, $temp_reprod->id, $item->id_ciclo]) }}" class="btn alert-success btn-sm" title="Series para Reproducción">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
          						  </a>
                        <a href="{{ route ('lotemonta',[$finca->id_finca, $temp_reprod->id, $item->id_ciclo]) }} " class="btn alert-success btn-sm" title="Crear Lote de Monta">
                          <i class="fas fa-chart-pie mr-1"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach()
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
</div>

</div>
@stop

@section('css')
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">
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
    {!! Html::script('bootstrap4-duallistbox/jquery.bootstrap-duallistbox.js')!!}  	
    
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
