@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-6"> <!-- Col1 -->
			<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title title-header">Temporada o Ciclo de Reproducción</h3>
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
	              <div class="card-body">

	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">

	              </div>
	        </div>
		</div>
		<div class="col-md-6">
			<div class="card">
	              <div class="card-header">
	                <h3 class="card-title">Title Form</h3>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">


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
    

@stop
