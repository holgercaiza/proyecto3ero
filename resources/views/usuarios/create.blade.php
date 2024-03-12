@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info text-center text-bolder">
                <div class="panel-heading ">Crear Usuario </div>
                <div class="panel-body">
                    <form action="{{route('usuarios.store')}}" method="POST" >
                        {{csrf_field()}}
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="usr_usuario">Usuario</label>
                            <input type="text" required class="form-control" name="usr_usuario" id="usr_usuario" >
                            <label for="email">Correo</label>
                            <input type="text" required class="form-control" style="margin-top:10px" name="email" id="email"  >
                            <div style="margin-top:10px">
                                <button type="submit" class="btn btn-primary pull-left">Guardar</button>
                                <a href="{{route('usuarios.index')}}" class="pull-right text-danger">Regresar</a>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
