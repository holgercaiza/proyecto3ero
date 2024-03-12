@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
            <div class="panel panel-info text-center text-bolder">
                <div class="panel-heading ">GENERAR ÓRDENES DE PENSIÓN</div>
                <form action="{{ route('generar_ordenes') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-inline text-left">
                    <div class="form-group">
                            <select name="anl_id" id="anl_id" class="form-control">
                                @foreach($periodos as $p)
                                    <option value="{{ $p->id }}">{{ $p->anl_descripcion }}</option>
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
                            <select name="mes" id="mes" class="form-control">
                                <option value="">Elija el mes</option>
                                <option value="MT">MATRICULA</option>
                                <option value="S">SEPTIEMBRE</option>
                                <option value="O">OCTUBRE</option>
                                <option value="N">NOVIEMBRE</option>
                                <option value="D">DICIEMBRE</option>
                                <option value="E">ENERO</option>
                                <option value="F">FEBRERO</option>
                                <option value="M">MARZO</option>
                                <option value="A">ABRIL</option>
                                <option value="MY">MAYO</option>
                                <option value="J">JUNIO</option>
                                <option value="JL">JULIO</option>
                                <option value="AG">AGOSTO</option>
                            </select>
                     </div>   

                    <div class="form-group">
                        <button type="submit" name="btn_genera_ordenes" value="btn_genera_ordenes" class="btn btn-primary">Generar</button>
                    </div>

                </div>

                </form>
            </div>
    </div>
    <div class="row">

        <table class="table" >
            <tr>
                <th>#</th>
                <th>Secuencial</th>
                <th>Periodo</th>
                <th>Jornada</th>
                <th>Mes</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
            @foreach($ordenes_generadas as $og)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $og->secuencial }}</td>
                  <td>{{ $og->anl_descripcion }}</td>
                  <td>{{ $og->jor_descripcion }}</td>
                  <td>{{ $og->mes }}</td>
                  <td>{{ $og->fecha_registro }}</td>
                  <td>
                      <a href="{{ route('ver_ordenes_generadas',$og->secuencial) }}" class="btn btn-info btn-xs" > <i class="fa fa-list" ></i> </a>
                      <a href="{{ route('excel_ordenes_generadas',$og->secuencial) }}" class="btn btn-success btn-xs" > <i class="fa fa-file-excel-o" ></i> </a>
                      <form action="{{ route('elimina_ordenes_generadas') }}" method="POST" onsubmit="return confirm('Desea Eliminar?')">
                          {{ csrf_field() }}
                          <input type="hidden"  name="secuencial" value="{{ $og->secuencial }}" >
                          <button type="submit" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i> </button>
                      </form>
                      
                      
                  </td>
               </tr>
            @endforeach
        </table>

    </div>
</div>
@endsection