@extends('layouts.app')

@section('content')
<?php 
$desde=date('Y-m-d');
$hasta=date('Y-m-d');
?>
<div class="container-fluid">

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="container">
            <a href="{{ route('usuarios.create') }}" style="margin:5px;display:none" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Nuevo</a>

                    <table class="table">
                        <tr>
                           <th>#</th> 
                           <th>Usuario</th> 
                           <th>Correo</th> 
                           <th>Acciones</th>
                        </tr>
                        @foreach($usuarios as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $u->usr_usuario }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="input-group">
                                               <span class="input-group-btn">
                                                     <a href="{{ route('usuarios.edit',$u->usr_id) }}" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
                                                     <a href="{{ route('usuarios.show',$u->usr_id) }}" class="btn btn-warning btn-xs"><i class="fa fa-key "></i></a>
                                                 </span>
                                                 <form action="{{ route('usuarios.destroy',$u->usr_id) }}" style="display:none" method="POST">
                                                    {{ csrf_field() }}
                                                    <input name='_method' type='hidden' value='DELETE'>
                                                    <button class="btn btn-danger btn-xs" onclick="return confirm('Desea Eliminar')" type="submit"><i class="glyphicon glyphicon-trash"></i></button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
    </div>
</div>
@endsection
