@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
  <div class="row">
    <div class="col card-especie mr-3 border-style"> <!--Form y Validación-->
      
      <div class="row row-list border-bottom">
        <div class="col title-header">Ficha de Sub Lotes</div>
      </div>
       @if(session('msj'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>¡Felicidades!</strong> {{ session('msj') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      <div class="row my-4">
        <div class="form-registro">
          <form action="" method="POST">
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
                <div class="row">
                  <div class="col">
                      <div class="form-group">
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
                  </div>
                  <div class="col">
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
              <button type="submit" class="btn alert-success aling-boton">
              <i class="fas fa-plus"></i> Asignar</button>
              <a href="#" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              </svg> volver</a>
          </form>
        </div>
      </div>
    </div>
    <div class="col card-especie-grid ml-3 border-style"> <!--Grid -->
      
      <div class="row row-list border-bottom">
          <div class="col title-header">El Lote "{{ $lote->nombre_lote }}" posee </div>
      </div>
      <table class="table table-especie">
          <thead>
            <tr>
              <th scope="col">Sub Lote</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody>          
                @foreach ($sublote as $item)
                <tr>
                  <td>
                    {{ $item->sub_lote}}
                  </td>
                  <td>
                  <a href="{{ route('lote') }}" class="btn btn-warning btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                  </svg></a>  
                  <form action="{{ route('sublote.eliminar', $item->id_sublote) }}" class="d-inline" method="POST">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                  </svg> </button>
                  </form>
                      
                      <a href="{{ route ('seriesensublote', $item->id_sublote) }}" class="btn alert-success btn-sm"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                      <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                      </svg></a>
                    
                  </td>
                </tr>
                @endforeach()  
          </tbody>
      </table>
    </div>
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
