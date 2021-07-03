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
          <h3 class="card-title title-header">Crear Rol</h3>
        </div>
        @if(session('msj'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>¡Felicidades!</strong> {{ session('msj') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        <form action="{{ route('roles.store') }}" method="POST">
          @csrf
          @error('name')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Atención!</strong> El nombre del Rol es obligatorio o ya existe.
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
                <label>Nombre del Rol</label>
                  <input 
                  class="form-control" 
                  id="name" 
                  type="text" 
                  name="name"  
                  placeholder="Ingrese el nombre del rol" 
                  value="{{ old('name') }}">
              </div>            
            </div>
            <div class="col oculto">
              <div class="form-group">
                <label>slug</label>
                  <input 
                  class="form-control" 
                  id="slug" 
                  type="text" 
                  name="slug"
                  readonly="true"  
                  placeholder="slug" 
                  value="{{ old('slug') }}">
               </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Descripción</label>
                  <input 
                  class="form-control" 
                  id="description" 
                  type="text" 
                  name="description" 
                  placeholder="Descripción del Rol" 
                  value="{{ old('description') }}">
              </div>
            </div>
          </div>
            <hr>
            <div class="col">
              <h3 class="title-header">Acceso Completo</h3>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fullaccess" id="fayes" value="yes">
                <label class="form-check-label title-label" for="fayes">
                  Sí
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fullaccess" id="fano" value="no" checked>
                <label class="form-check-label title-label" for="fano">
                  No
                </label>
              </div>
            </div> 
            <hr>
            <div class="row">
                <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th style="width: 10px; text-align: center;">#</th>
                      <th>Nombre del Permiso</th>
                      <th>Descripción</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($permisos as $item)
                      <tr>
                        <td style="width: 5%;text-align: center;">
                            <div class="form-check">        
                              <input 
                                class="form-check-input" 
                                type="checkbox" 
                                value="{{ $item->id }}" id="permisos_{{$item->id}}"
                                name="idpermiso[]">
                            </div>  
                          </td>
                        <td>{{$item->name}}</td>
                        <td>
                            {{$item->description}}
                        </td>
                      </tr>
                    @endforeach() 
                  </tbody>
                </table>
              </div>
            </div>
            
        </div>      
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <button type="submit" class="btn alert-success aling-boton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
              </svg> Registrar</button>
            <a href="{{ route('home') }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg> volver</a>  
        </div>
      </form> 
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
