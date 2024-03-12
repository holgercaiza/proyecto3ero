@extends('layouts.app')
@section('content')
<?php
$fecha=date('Y-m-d');
?>
<script src="{{ asset('js/estudiante.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info text-center text-bolder">
                <div class="panel-heading ">Registro de Pago de Pensiones</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-2">
                            <label for="est_id">Estudiante</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="est_id" id="est_id" placeholder="Nombe/Cedula del Estudiante" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <span class="btn btn-primary" id="btn_student_search">Buscar</span>
                        </div>
                    </div>

                    <div class="row" style="margin-top:20px" id="cont_datos_est" >

                    </div>

                    <form action="{{ route('pensiones.store') }}" method="POST" >
                        {{ csrf_field() }}
                        <input type="hidden" id="mat_id" name="mat_id">
                        <div class="row" style="margin-top:20px;">
                            <div class="col-sm-2 "><label for="">Fecha</label></div>
                            <div class="col-sm-4"><input type="date" id="pag_fecha" name="pag_fecha" value="{{ $fecha }}" class="form-control"></div>
                            <div class="col-sm-2 "><label for="">Documento</label></div>
                            <div class="col-sm-4"><input type="text" id="pag_documento" name="pag_documento" class="form-control"></div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-sm-2 "><label for="">Valor</label></div>
                            <div class="col-sm-4"><input type="number" id="pag_valor" step="any" name="pag_valor" class="form-control"></div>
                            <div class="col-sm-2 "><label for="">Pago</label></div>
                            <div class="col-sm-4">
                                <select name="pag_pago" id="pag_pago" class="form-control">
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
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-sm-2 "><label for="">Descripcion</label></div>
                            <div class="col-sm-10">
                                <input type="text" id="pag_descripcion" name="pag_descripcion" class="form-control">
                            </div>
                        </div>                                
                        <div class="row text-left" style="margin-top:20px;padding:10px ;">
                            <button type="submit" class="btn btn-primary" >Guardar</button>
                            <a href="{{ route('pensiones.index') }}" class="btn btn-danger pull-right" >Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_search_student" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Elija un estudiante de la lista</h4>
      </div>
      <div class="modal-body">
        <table id="tbl_estudiantes" class="table">
            
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
