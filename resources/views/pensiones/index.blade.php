@extends('layouts.app')

@section('content')
<?php 
$desde=date('Y-m-d');
$hasta=date('Y-m-d');
?>
<div class="container-fluid">
    <div class="row">
            <a href="{{ route('pensiones.create') }}" style="margin:5px" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Nuevo</a>
            <div class="panel panel-default">
                <div class="panel-heading text-center" style="background:#d9edf7 ;">Administracion de Registro de Pago de Pensiones</div>
                <div class="panel-body">

                    <form action="{{ route('pensiones.buscar') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label for="desde">Desde</label>
                                </span>
                                <input type="date" name="desde" id="desde" value="{{ $desde }}" class="form-control">
                            </div>
                        </div>   
                        <div class="form-group col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label for="hasta">Hasta</label>
                                </span>
                                <input type="date" name="hasta" id="hasta" value="{{ $hasta }}" class="form-control">
                            </div>
                        </div>   

                        <div class="form-group col-sm-1">
                            <div class="input-group">
                                    <button type="submit" name="btn_buscar" value="btn_buscar" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>   

                    </form>

                    <table class="table">
                        <tr>
                           <th>#</th> 
                           <th>F.Registro</th> 
                           <th>Estudiante</th> 
                           <th>F.Pago</th> 
                           <th>Descripcion</th> 
                           <th>Documento</th> 
                           <th>Valor</th> 
                           <th>Pago</th> 
                        </tr>
                        @foreach($pensiones as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->pag_fecha_registro }}</td>
                                <td>{{ $p->est_apellidos }} {{ $p->est_nombres }}</td>
                                <td>{{ $p->pag_fecha }}</td>
                                <td>{{ $p->pag_descripcion }}</td>
                                <td>{{ $p->pag_documento }}</td>
                                <td>{{ $p->pag_valor }}</td>
                                <td>{{ $p->pag_pago }}</td>
                                <td>
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="input-group">
                                          <span class="input-group-btn">
                                             <a href="{{ route('pensiones.edit',$p->pag_id) }}" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
                                         </span>
                                         <form action="{{ route('pensiones.destroy',$p->pag_id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input name='_method' type='hidden' value='DELETE'>
                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Desea Eliminar')" type="submit"><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->


                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
    </div>
</div>
@endsection
