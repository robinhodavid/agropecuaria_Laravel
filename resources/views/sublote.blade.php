@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Información de Sub-Lote</h1>
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
    <div class="row my-4">
        <div class="form-registro">
            <form action=" {{ route('sublote.crear', $lote->id_lote) }}" method="POST">
                @csrf
                @error('sub_lote')
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <span>
                        <strong>Atención! </strong>El campo Sub Lote es requerido.
                      </span>
                      <br>
                      <span>o</span>
                      <br>
                      <span>
                        <strong>Atención! </strong>El registro Lote y Sub lote ya existe.
                      </span>
                      
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @enderror
                <div class="form-group">
                    <div class="row -my-4">
                        <div class="col-8 border-top border-right border-left">
                            <h5>Lote Principal</h5>
                        </div>
                        <div class="col-4 bck-ground border-top border-right border-left">
                            <h5>Sub lote</h5>
                        </div>
                        <div class="col-8 border-top border-right border-left border-bottom border-style">
                        
                        <label class="col-form-label">Lote:</label>
                        <input 
                        class="form-control" 
                        id="nombre_lote" 
                        type="text" 
                        name="nombre_lote"  
                        placeholder="Ingrese Nombre del lote" 
                        readonly="true" 
                        value="{{ $lote->nombre_lote }}">
                    </div>   
                    <div class="col-4 bck-ground border-top border-right border-left border-bottom border-style">
                    <select class="form-select" name="sub_lote" size="6" aria-label="size 3 select example">
                          <option value="" selected>Seleccione un sub lote</option>
                          <option value="Lote 1">Lote 1</option>
                          <option value="Lote 2">Lote 2</option>
                          <option value="Lote 3">Lote 3</option>
                          <option value="Lote 4">Lote 4</option>
                          <option value="Lote 5">Lote 5</option>
                    </select>
                    
                </div>  
                </div>
                <div class="my-4">
                <button type="submit" class="btn alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                 <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                </svg> Registrar</button>
                    <a href="{{ route('lote') }}" class="btn btn-warning">volver</a>
                </div>
            </form>     
        </div>
    </div>
</div>

<div class="container">
    <div class="row my-4">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Lote</th>
              <th scope="col">Sub Lote</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody>          
                @foreach ($sublote as $item)
                <tr>
                  <td>
                    <a href="#" class="">
                    {{ $item->nombre_lote}}
                    </a>
                  </td>
                  <td>
                    {{ $item->sub_lote}}
                  </td>
                  <td>
                    <form action="{{ route('sublote.eliminar', $item->id_sublote) }}" class="d-inline" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                        Eliminar
                        </button>
                    </form>
                    <a href="{{ route ('seriesensublote', $item->id_sublote) }}" class="btn alert-success btn-sm">Detalle</a>
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
