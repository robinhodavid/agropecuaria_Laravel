@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')
@if(session('msj'))
 	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong>¡Felicidades!</strong> {{ session('msj') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
	</div>
 @endif
<div class="container">
	<div class="row">
		<div class="form-registro">
			<form action="{{ route('pesoespecifico.crear', [$finca->id_finca, $serie->serie]) }}" method="POST">
				@csrf
				@error('fecha')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span>
                    <strong>Atención! </strong>El Campo Fecha de Pesaje es requerido o el <strong>Registro de Peso Existe.</strong>
                  </span>         
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @enderror
                @error('peso')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span>
                    <strong>Atención! </strong>El Campo peso es requerido.
                  </span>         
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @enderror
				<div class="col-md-12">
		            <div class="card">
		              <div class="card-header">
		                <h3 class="card-title title-header">Registro de Peso Específico</h3>
		                <h2 class="card-title title-header">Serie: {{$serie->serie }} </h2>
		                <h2 class="card-title title-header">Tipología Actual: {{$serie->tipo}}</h2>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body">
		              	<div class="row">
		              		<div class="col-3">
		              			<label class="col-form-label">Fecha de Pesaje:</label>
								<div class="input-group mb-3">
								  	<input 
								  	type="date"
								  	id="fecha" 
								  	name="fecha"
								  	class="form-control" 
								  	min="1980-01-01" 
							  		max="2031-12-31"
								  	aria-label="fecr" aria-describedby="basic-addon2">
									<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
									<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
									<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
									</svg></span>
								</div> 
								<div class="row">
									<div class="col">    
								        <label class="col-form-label">Peso:</label>
										<input 
										    class="form-control" 
										    id="peso" 
										    type="number" 
										    name="peso" 
										    min="0" 
										    step="any"
										    placeholder="Peso" 
										    value="{{ old('peso') }}">
					                </div>     	
									<div class="col" style="text-align: center;margin-top: 24px;">
										@if($serie->destatado==true)
											<div class="form-check form-switch oculto">
							                    <input 
							                    class="form-check-input oculto"
							                    name="destatado" 
							                    type="checkbox" 
							                    id="destatado" 
							                    >
							                    <label class="form-check-label oculto" for="destatado">¿Es Peso de Destete?</label>
						                	</div> 
										@else
											<div class="form-check form-switch">
							                    <input 
							                    class="form-check-input"
							                    name="destatado" 
							                    type="checkbox" 
							                    id="destatado" 
							                    >
							                    <label class="form-check-label" for="destatado">¿Es Peso de Destete?</label>
						                	</div> 
										@endif
										
							        </div>
							        
			              		</div>	
		              		</div>
		              		<div class="col">
		              			<div class="row">
		              				<div class="col">
		              					<label class="col-form-label">Fecha del Peso Inicial:</label>
							            <div class="input-group mb-3">
							                <input 
							                type="date" 
							                name="fecr"
							                id="fecr"
							                class="form-control"
							                value="{{ $serie->fecr }}" 
							                min="1980-01-01" 
							                max="2031-12-31"
							                readonly="true" 
							                aria-label="fecha" aria-describedby="basic-addon2">
							                <span class="input-group-text" id="basic-addon2">
							                	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
							                  	<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
							                  	<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
							                  </svg>
							              </span>
							            </div>   
		              				</div>
		              				<div class="col">
		              					<label class="col-form-label">Fecha último pesaje:</label>
							            <div class="input-group mb-3">
							                <input 
							                type="date" 
							                name="fulpes"
							                id="fulpes"
							                class="form-control"
							                value="{{ $serie->fulpes  }}" 
							                min="1980-01-01" 
							                max="2031-12-31"
							                readonly="true" 
							                aria-label="fecha" aria-describedby="basic-addon2">
							                <span class="input-group-text" id="basic-addon2">
							                	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
							                  	<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
							                  	<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
							                  </svg>
							              </span>
							            </div>   
		              				</div>
		              				<div class="col">
		              					<label class="col-form-label">Peso Inicial:</label>
								            <input 
								            class="form-control" 
								            id="pesoi" 
								            type="text" 
								            name="pesoi"  
								            readonly="true" 
								            value="{{ $serie->pesoi }}"> 
		              				</div>
		              				<div class="col">
		              					<label class="col-form-label">Peso Actual:</label>
								            <input 
								            class="form-control" 
								            id="pesoactual" 
								            type="text" 
								            name="pesoactual"  
								            readonly="true" 
								            value="{{ $serie->pesoactual	 }}"> 
		              				</div>
		              			</div>
		              			<div class="row">
		              				<div class="col">
		              				<label class="col-form-label">GDP:</label>
								            <input 
								            class="form-control" 
								            id="gdp" 
								            type="text" 
								            name="gdp"  
								            readonly="true" 
								            value="{{ old('ultgdp') }}">     	
		              				</div>
		              				<div class="col">
		              					<label class="col-form-label">Días:</label>
								            <input 
								            class="form-control" 
								            id="dias" 
								            type="text" 
								            name="dias"  
								            readonly="true" 
								            value="{{ $dias }}">
		              				</div>
		              				<div class="col">
		              					<label class="col-form-label">Peso Ganado</label>
								            <input 
								            class="form-control" 
								            id="pgan" 
								            type="text" 
								            name="pgan"  
								            readonly="true" 
								            value="{{ old('pgan') }}">
		              				</div>
		              				<div class="col">
		              					<label class="col-form-label">Diferencia día</label>
								            <input 
								            class="form-control" 
								            id="difdia" 
								            type="text" 
								            name="difdia"  
								            readonly="true" 
								            value="{{ old('difdia') }}">
		              				</div>
		              			</div>
		              		</div>
		              	</div>
		              </div>
		              <!-- /.card-body -->
		              <div class="card-footer clearfix">
		                <a href="{{route('fichaganado.editar',[$finca->id_finca, $serie->serie] )}}" class="btn btn-warning float-rigth"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
			  			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
						</svg> volver</a>

						<button type="submit" class="btn alert-success float-rigth">
		                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
		                 <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
		                </svg> Registrar</button>
		              </div>
		            </div>
		            <!-- /.card -->
		        </div>  
	    	</form>
	    </div>
	</div> <!--/.row -->
	<div class="row">
	        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Registros de pesos</h3>
                	<a href="{{ route('pesoespecifico.reporte', [$finca->id_finca, $serie->serie]) }}" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th>Fecha</th>
                      <th>Peso</th>
                      <th>GDP</th>
                      <th>Días</th>
                      <th>Peso Ganado</th>
                      <th>Dif Día</th>
                      <th style="width: 20%; text-align: center;">¿Es peso de Destete?</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@foreach($registropeso as $item)
                    <tr>
                    	<td>
                      		{{ $item->fecha }}
                    	</td>
	                    <td>
	                      {{ $item->peso }}
	                    </td>
	                    <td>
	                      {{ $item->gdp }}
	                    </td>
	                    <td>
	                      {{ $item->dias }}
	                    </td>
	                     <td>
	                      {{ $item->pgan }}
	                    </td>
	                     <td>
	                       {{ $item->difdia }}
	                    </td>
	                    <td style="text-align: center;">
	                    	<input type="checkbox" name="destetado" disabled="true"
	                    	{{$item->destetado?"checked":""}}
	                    	>
	                    </td>
	                    <td>
		                   	<form action="{{ route ('pesoespecifico.eliminar', [$finca->id_finca, $item->id]) }}" class="d-inline form-delete" method="POST">
		                      @method('DELETE')
		                      @csrf
		                      <button type="submit" class="btn btn-danger btn-sm">
		                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
		                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
		                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
		                    </svg> 
		                    </button>
		                    </form>	
	                    </td>
                	</tr>
                    @endforeach()

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $registropeso->links() }}
              </div>
            </div>
            <!-- /.card -->
        	</div>	
	</div>
	<div class="row">
		<div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                   <h3 class="card-title title-header">Gráfica de Peso Específico</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span>Pesos Registrados</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                 
                  <canvas id="chartkg" height="200" width="488" class="chartjs-render-monitor" style="display: block; width: 488px; height: 200px;"></canvas>
                </div>

        <!--        <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This Week
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last Week
                  </span>
                </div>
		-->
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>
	
    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
	});
    </script>
    
    <script>
    $(function(){
    	var graficapeso = <?php echo json_encode($graficapeso); ?>;
    	var graficafecha= <?php echo json_encode($graficafecha); ?>;
    	var ctx = document.getElementById('chartkg');
    	
    	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: graficafecha,//['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
	        datasets: [{
	            label: 'Registros de Pesos',
	            data: graficapeso,//[12, 19, 3, 5, 2, 3],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255, 99, 132, 1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});

   })
	

</script>

   <!-- <script src="http://momentjs.com/downloads/moment.min.js"></script>
	-->

	{!! Html::script('js/jquery-3.5.1.min.js')!!}
    {!! Html::script('js/dropdown.js')!!} 
    
    {!! Html::script('js/sweetalert2.js')!!}	
    
  	@if(session('mensaje')=='ok')
	  	<script>
	  		Swal.fire({
				title: '¡Tipología Actualizada!',
				text:  'El registro de peso Generó un cambio de Tipología',
				icon:  'info'
			})
	  	</script>
	@endif 
	@if(session('mensaje')=='dok')
	  	<script>
	  		Swal.fire({
				title: '¡Registro de Peso!',
				text:  'El registro de peso fue eliminado exitosamente',
				icon:  'info'
			})
	  	</script>
	@endif 
	@if(session('mensaje')=='nok')
	  	<script>
	  		Swal.fire({
				title: '¡Peso de Destete no registrado!',
				text:  'El registro de peso no pudo generar un cambio de Tipología, se sugiere hacerlo Manualmente por la Edición de Ficha de Ganado y luego Realizar un Registro de Peso para actualizar su peso',
				icon:  'error'
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
