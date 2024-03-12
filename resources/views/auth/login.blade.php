@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <img src="{{ asset('img/escudo.png') }}" width="50px" alt="">
                    Ingreso al sistema de pago de pensiones UETVN
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group row text-center">
                            <div class="col-md-4">
                                <label for="usr_usuario" class="control-label pull-right">Campus</label>
                            </div>
                            <div class="col-md-5">
                                <select name="campus" id="campus" class="form-control" required >
                                    <option value="">Elija Un Campus</option>
                                    @foreach($sucursales as $s)
                                    <option value="{{$s->id}}">{{$s->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div class="form-group{{ $errors->has('usr_usuario') ? ' has-error' : '' }}">
                            <label for="usr_usuario" class="col-md-4 control-label">Usuario</label>
                            <div class="col-md-6">
                                <input id="usr_usuario" type="text" class="form-control" name="usr_usuario" value="{{ old('usr_usuario') }}" required autofocus>
                                @if ($errors->has('usr_usuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usr_usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Ingresar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
