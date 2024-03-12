@extends('layouts.app')
@section('content')
<?php 
if(isset($dt['jor_id'])){
$jor_id=$dt['jor_id'];
$esp_id=$dt['esp_id'];
$cur_id=$dt['cur_id'];
$paralelo=$dt['paralelo'];
$mes=$dt['mes'];
}else{
$jor_id=1;
$esp_id=10;
$cur_id=1;
$paralelo='A';
$mes='MAT';    
}
?>
<style>
    *{
        font-family:Comic Sans;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-info text-center text-bolder">
            <div class="panel-heading ">
            <div class="panel-body">

                <form action="{{ route('reportes') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-inline">
                    <div class="form-group">
                        <select name="anl_id" id="anl_id" class="form-control">
                            @foreach($anios as $an)
                            <option value="{{$an->id}}">{{$an->anl_descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                            <select name="jor_id" id="jor_id" class="form-control">
                                <option value="1">Matutina</option>
                                <option value="3">Semipresencial</option>
                            </select>
                    </div>
                    <div class="form-group">
                            <select name="esp_id" id="esp_id" class="form-control">
                                <option value="10">Cultural</option>
                                <option value="7">BGU</option>
                                <option value="8">Básica Flexible</option>
                            </select>
                    </div>

                    <div class="form-group">
                            <select name="cur_id" id="cur_id" class="form-control">
                                <option value="1">Octavo</option>
                                <option value="2">Noveno</option>
                                <option value="3">Décimo</option>
                                <option value="4">Primero</option>
                                <option value="5">Segundo</option>
                                <option value="6">Tercero</option>
                            </select>
                    </div>

                    <div class="form-group">
                            <select name="paralelo" id="paralelo" class="form-control">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                     </div>   

                    <div class="form-group">
                        <button type="submit" name="btn_buscar" value="btn_buscar" class="btn btn-primary"> Mostrar <i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>

                    <div class="form-group">
                        <label for="mes">Mes</label>
                            <select name="mes" id="mes" class="form-control">
                                <option value="MAT">MAT</option>
                                <option value="SEP">SEP</option>
                                <option value="OCT">OCT</option>
                                <option value="NOV">NOV</option>
                                <option value="DIC">DIC</option>
                                <option value="ENE">ENE</option>
                                <option value="FEB">FEB</option>
                                <option value="MAR">MAR</option>
                                <option value="ABR">ABR</option>
                                <option value="MAY">MAY</option>
                                <option value="JUN">JUN</option>
                                <option value="JUL">JUL</option>
                                <option value="AGO">AGO</option>
                            </select>
                     </div>   

                    <div class="form-group">
                        <button type="submit" name="btn_buscar_deudores" value="btn_buscar_deudores" class="btn btn-danger">Deudores <i class="glyphicon glyphicon-alert"></i></button>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btn_buscar_deudores" value="btn_deudores_lista" title="Lista de general de pagos" class="btn btn-info ">General <i class="glyphicon glyphicon-list"></i></button>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btn_buscar_deudores_consolidado" value="btn_deudores_consolidado" title="Lista de general de pagos" class="btn btn-primary ">Consolidado <i class="fa fa-area-chart" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                </form>
            </div>





            <div class="container-fluid">
                <?php 
                $est="";
                $x=1;
                ?>
                @foreach($pensiones as $p)
                @if($est!=$p->mat_id)
                <div class="row">
                    <div class="col-md-12">{{ $x }} {{ $p->est_apellidos }} {{ $p->est_nombres }}</div>
                    @if(isset($dt['esp_id'])=='10')
                        <div class="col-md-12"><small>{{ $p->jor_descripcion.' / '.$p->cur_descripcion.' / '.$p->mat_paralelo }} </small></div>
                    @else
                        <div class="col-md-12"><small>{{ $p->jor_descripcion.' / '.$p->cur_descripcion.' / '.$p->esp_descripcion.' / '.$p->mat_paralelo }} </small></div>
                    @endif
                </div>
                <div class="row bg-info" style="margin:0px 5px 0px 5px;">
                    <div class="col-md-2">Fecha</div>
                    <div class="col-md-5">Descripcion</div>
                    <div class="col-md-2">Documento</div>
                    <div class="col-md-1">Valor</div>
                    <div class="col-md-1">Pago</div>
                </div>
                <div class="row">
                    <div class="col-md-2">{{ $p->pag_fecha }}</div>
                    <div class="col-md-5 text-left">{{ $p->pag_descripcion }}</div>
                    <div class="col-md-2">{{ $p->pag_documento }}</div>
                    <div class="col-md-1">{{ $p->pag_valor }}</div>
                    <div class="col-md-1">{{ $p->pag_pago }}</div>
                    <div class="col-md-1">
                        <a href="{{ route('pensiones.editpag',$p->pag_id) }}" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
                    </div>
                </div>
                <?php 
                    $est=$p->mat_id;
                    $x++;
                ?>
                @else
                <div class="row">
                    <div class="col-md-2">{{ $p->pag_fecha }}</div>
                    <div class="col-md-5 text-left">{{ $p->pag_descripcion }}</div>
                    <div class="col-md-2">{{ $p->pag_documento }}</div>
                    <div class="col-md-1">{{ $p->pag_valor }}</div>
                    <div class="col-md-1">{{ $p->pag_pago }}</div>
                    <div class="col-md-1">
                        <a href="{{ route('pensiones.editpag',$p->pag_id) }}" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
                    </div>
                </div>
                @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
<script>
    $(()=>{
        $("#jor_id").val("{{ $jor_id }}");
        $("#esp_id").val("{{ $esp_id }}");
        $("#cur_id").val("{{ $cur_id }}");
        $("#paralelo").val("{{ $paralelo }}");
        $("#mes").val("{{ $mes }}");
    })
</script>

@endsection
