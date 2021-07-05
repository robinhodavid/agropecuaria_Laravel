	@extends('adminlte::page')

	@section('title', 'SISGA')

	@section('content_header')

	@stop

	@section('content')
	<div class="container">
		<div class="row my-2">  
			<div class="col"> 
				<div role="tabpanel">
					<h3 class="title-header">Reportes Series Próximas a Palpar</h3>
					<ul class="nav nav-tabs" role="tablist">
						<li id="Ganaderia" class="nav-item title-tipo" role="presentation">
							<a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Post-Servicio</a>
						</li>
						<li  id="Reproduccion" class="nav-item title-tipo" role="presentation">
							<a class="nav-link" href="#seccion2" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Post-Parto</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" role="tabpanel" id="seccion1">
							<form action="{{ route ('print_report', $finca->id_finca) }}" method="POST" target="_blank" >
								@csrf	
								<div class="row my-2">
								</div> {{--Fin Row--}}
							</form>	 
						</div>   
<!--Seccion2-->						 
						<div class="tab-pane" role="tabpanel" id="seccion2">
							<form action="{{ route ('print_report_reproducion', $finca->id_finca) }}" method="POST" target="_blank" >
								@csrf	 
								<div class="row celos my-2">
								</div>
							</form>      
					</div>
				</div>
			</div>
		</div>
	</div>


</div>

@stop

@section('css')

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<!-- daterange picker -->
<link rel="stylesheet" href="/css/daterangepicker.css">
<link rel="stylesheet" href="/css/tempusdominus-bootstrap-4.css">
<link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">

<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')

{!! Html::script('js/jquery.min.js')!!}
{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!}
<!--{!! Html::script('js/moment.min.js')!!}-->
<!--{!! Html::script('js/package.js')!!}-->
<!--{!! Html::script('js/website.js')!!}-->
<!--{!! Html::script('js/daterangepicker.js')!!}-->
<!--{!! Html::script('js/tempusdominus-bootstrap-4.min.js')!!}-->
{!! Html::script('js/sweetalert2.js')!!}  
{!! Html::script('js/metodos.js')!!}
  


<!-- Page script -->
<script>
  $(function () {
    
/*  	  //Date range picker
    $('#fecharegistro').datetimepicker({
        //format: 'L'
        locale: {
        format: 'YYYY-MM-DD'
      }
    });
*/
 		//Date range picker Fecha de Registro
    
    $('#fecharegistro').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }); 

    //Date range picker Fecha de Nacimiento
    $('#fechanacimiento').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }); 

    //Date range picker Fecha de Destete
    $('#fechadestete').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }); 

  })
</script>

<script>
	$('.form-trans').submit(function(e){

		var ddesde = new Date(document.getElementById('fddesde').value);    
		var dhasta = new Date(document.getElementById('fdhasta').value);

		if (ddesde > dhasta) {
			e.preventDefault();
			Swal.fire({
				text:'La Fecha "Hasta" no puede ser anterior a la fecha "Desde"',
				icon: 'error',
				title:'¡Rango de Fecha No valido!'
			})
		}
	}); 
</script>
<script>
	$('.form-trans').submit(function(e){

		var desde = new Date(document.getElementById('frdesde').value);    
		var hasta = new Date(document.getElementById('frhasta').value);

		if (desde > hasta) {
			e.preventDefault();
			Swal.fire({
				text:'La Fecha "Hasta" no puede ser anterior a la fecha "Desde"',
				icon: 'error',
				title:'¡Rango de Fecha No valido!'
			})
		}
	}); 
</script>
<script>
	$('.form-trans').submit(function(e){

		var pdesde = document.getElementById('pdesde').value;    
		var phasta = document.getElementById('phasta').value;

		if (pdesde > phasta) {
			e.preventDefault();
			Swal.fire({
				text:'El Valor del Peso "Hasta" no puede ser menor al valor del Peso "Desde"',
				icon: 'error',
				title:'¡Rango de Peso No valido!'
			})
		}
	}); 
</script>


@stop



