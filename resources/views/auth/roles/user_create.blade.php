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
          <h3 class="card-title title-header">Crear Usuario</h3>
        </div>
        @if(session('msj'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>¡Felicidades!</strong> {{ session('msj') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        <form action="{{ route('usuario.store') }}" method="POST">
        @csrf
        @error('name')
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atención!</strong> El nombre del Usuario es obligatorio o ya existe.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @enderror
        @error('email')
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atención!</strong> El correo del usuario es obligatorio o ya existe.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @enderror
        @error('password')
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Atención!</strong> Se requiere una contraseña mayor a 6 caracteres.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @enderror
        @error('rol')
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atención!</strong> El campo Rol es Requerido.
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
                <label>Nombre de Usuario</label>
                  <input 
                  class="form-control" 
                  id="name" 
                  type="text" 
                  name="name"  
                  placeholder="Ingrese el nombre del Usuario" 
                  value="{{ old('name') }}">
              </div>            
            </div>
            <div class="col">
              <div class="form-group">
                <label>Correo</label>
                  <input 
                  class="form-control" 
                  id="email" 
                  type="email" 
                  name="email"  
                  placeholder="Ingrese el email" 
                  value="{{ old('email') }}">
              </div>            
            </div>
            <div class="col ">
              <div class="form-group">
                <label>Contraseña</label>
                  <input 
                  class="form-control" 
                  id="password" 
                  type="password" 
                  name="password"
                  placeholder="Ingrese una Contraseña" 
                  value="{{ old('password') }}">
               </div>
            </div>
            <div class="col">
               <label>Rol</label>
              <select class="form-select" aria-label="Default select example" name="rol">
                <option value="" selected>Seleccione un Rol</option>
                @foreach($roles as $rol)
                <option value="{{$rol->id}}">{{$rol->name}}</option>
                @endforeach()
              </select>
            </div>
          </div>
            <hr>
            <div class="col">
              <h3 class="title-header">Fincas</h3>
              @foreach($finca as $item)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $item->id_finca }}" id="finca_{{$item->id_finca}}" name="idfinca[]">
                <label class="form-check-label" for="finca_{{$item->id_finca}}">
                  {{$item->nombre}}
                </label>
              </div>
              @endforeach()
            </div>
        </div>      
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <button type="submit" class="btn alert-success aling-boton">
            <i class="far fa-save"></i> Registrar</button>
            <a href="{{ route('usuario.index') }}" class="btn btn-warning aling-boton"><i class="fas fa-arrow-left"></i> volver</a>  
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
