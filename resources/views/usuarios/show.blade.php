@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info text-center text-bolder">
                <div class="panel-heading ">Cambiar Clave {{$usuario->usr_usuario}}</div>
                <div class="panel-body">
                    <form action="{{route('usuarios.update',$usuario->usr_id)}}" method="POST" onsubmit="return validar()">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="password">Nueva Clave</label>
                            <input type="password" required class="form-control" name="password" id="password" value="" >
                            <label for="password2">Confirmar Nueva Clave</label>
                            <input type="password" required class="form-control" name="confirm_password" id="confirm_password" value="" style="margin-top:10px" >
                            <small class="alert-danger alert_error" style="padding:5px;display:none;">Claves no coinciden</small>
                            <div style="margin-top:10px">
                                <button type="submit" class="btn btn-primary pull-left" name="bn_save_key" value="bn_save_key">Cambiar Clave</button>
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
<script>
    function validar(){
        const p1=document.querySelector('#password').value;
        const p2=document.querySelector('#confirm_password').value;
        if(p1!=p2){
            $(".alert_error").css('display','block');
            return false;
        }
    }
</script>
@endsection
