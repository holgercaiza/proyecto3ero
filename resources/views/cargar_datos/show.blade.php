@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info text-center text-bolder">
                <div class="panel-heading ">Detalle de registro de pagos</div>
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>F.Registro</th>
                        <th>Codigo</th>
                        <th>Concepto</th>
                        <th>Documento</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Detalle</th>
                    </tr>
                    @foreach($doc_pensiones_banco as $d)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $d->dpb_fecha_registro }}</td>
                        <td>{{ $d->dpb_codigo }}</td>
                        <td>{{ $d->dpb_concepto }}</td>
                        <td>{{ $d->dpb_documento }}</td>
                        <td>{{ $d->dpb_monto }}</td>
                        @if($d->dpb_estado==1)
                            @if(!empty($d->jor_descripcion))
                                <td>
                                    <div class="bg-success" >
                                        <div>
                                            <span class="bg-primary text-white" style="padding:1px;border-radius:2px" >{{ $d->pag_pago }}</span>
                                            <form action="{{ route('elimina_registro_pago') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{ $d->dpb_id }}" name="dpb_id" >
                                                <button type="submit" class="btn btn-danger btn-xs pull-right" onclick="return confirm('Está seguro de Eliminar \n No se podrá recuperar los datos ')" ><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                        <div><strong style="font-size:11px" >{{ $d->est_apellidos.' '.$d->est_nombres }}</strong></div>
                                        <div><small style="font-size:9px;color:#5a5a5a " >{{ $d->jor_descripcion.' '.$d->cur_descripcion.' '.$d->mat_paralelo }}</small></div>
                                    </div>
                                </td>
                            @else
                            <td></td>
                            @endif
                        @else
                            <td>
                                <div class="bg-danger" >
                                    <small>Eliminado</small>
                                </div>   
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
