@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
  <div class="row">

    <div class="card-tools my-2">
      <a href="{{route('usuario.create')}}" class="btn  alert-success btn-sm aling-boton" title="Crear Rol"><i class="fas fa-plus"></i></a>
    </div>  
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title title-header">Lista de Usuarios</h3>

          <div class="card-tools my-2">
          <form action="{{ route('usuario.index') }}" method="GET">  
            
            <div class="input-group input-group-sm" style="width: 180px;">
              <input type="text" name="search" class="form-control float-right" placeholder="Buscar usuario...">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>email</th>
                <th>Role (s)</th>
                <th style="text-align:center; width: 15%;">Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user as $item)
                <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->email}}</td>
                  <td>
                    @isset($item->roles[0]->name)
                      {{$item->roles[0]->name}}
                    @endisset
                  </td>
                  <td style="text-align:center; width: 15%;">
                    
                    <a href="{{route('usuario.edit',$item->id)}}" class="btn alert-success btn-sm" title="Editar Registro"><i class="fas fa-user-edit"></i></a>

                   <form action="{{ route('usuario.destroy',$item->id) }}" class="d-inline form-delete" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Registro"><i class="fas fa-trash-alt"></i>
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
          {{$user->links() }}
        </div>
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
