@if($op==0)
        @extends('layouts.app')
        @section('content')
        <div class="container-fluid">
                    <div class="panel panel-info text-center text-bolder">
                        <div class="panel-heading ">
                            Reporte General de Pago de Pensiones
                            <form action="{{ route('reportes') }}" method="POST">
                                {{ csrf_field() }}
                                <button class="btn btn-default" name="btn_buscar_deudores_consolidado" value="imprimible" style="display:none" ><i class="glyphicon glyphicon-print"></i></button>
                                <button class="btn btn-success" name="btn_buscar_deudores_consolidado" value="exportable" >Exportable <i class="fa fa-file-excel-o"></i></button>
                                <input type="hidden" name="anl_id" value="{{ $dt['anl_id'] }}">
                                <input type="hidden" name="jor_id" value="{{ $dt['jor_id'] }}">
                                <input type="hidden" name="esp_id" value="{{ $dt['esp_id'] }}">
                                <input type="hidden" name="cur_id" value="{{ $dt['cur_id'] }}">
                                <input type="hidden" name="paralelo" value="{{ $dt['paralelo'] }}">
                                <input type="hidden" name="mes" value="{{ $dt['mes'] }}">

                            </form>
                        </div>
                        <div class="panel-body">

                            @include('pensiones._lst_table_consolidado');

                        </div>
                    </div>
        </div>
        @endsection
@endif

@if($op==1)
     @include('pensiones.lista_consolidado_print');
@endif
@if($op==2)
     @include('pensiones.lista_consolidado_xls');

@endif