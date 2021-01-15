@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Series asigandas al Lote.: {{ $lote->nombre_lote }}</h1>
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
 
<a href="{{ route('lote') }}" class="btn btn-warning">volver</a> 
<div class="container">
    <div class="row my-4">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Serie</th>
              <th scope="col">Lote asignado</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody>          
                @foreach ($seriesenlote as $item)
                <tr>
                  <td>
                    <a href="#" class="">
                      {{ $item->serie }}
                    </a>
                  </td>
                  <td>
                    {{ $item->nombrelote }}
                  </td>
                  <td>
                    <a href="{{ route('lote') }}" class="btn btn-warning btn-sm">volver</a>
                  </td>
                </tr>
                @endforeach()  
          </tbody>
        </table>
    </div>
</div>






@stop

@section('css')
<!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

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
