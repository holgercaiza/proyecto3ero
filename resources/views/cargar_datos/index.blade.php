@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <h5 class="text-center bg-info" style="padding:5px ">Cargar datos de Pensiones
            <a href="{{ route('cargar_datos.create') }}" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Nuevo</a>
        </h5>
    </div>
    <table class="table">
        <thead>
            <tr>
            <th>#</th>
                <th>dbp_secuencial</th>
                <th>dpb_fecha_registro</th>
                <th>dpb_documento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doc_pensiones_banco as $item)
                <tr>
                <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->dbp_secuencial }}</td>
                    <td>{{ $item->dpb_fecha_registro }}</td>
                    <td>{{ $item->dpb_nombre_archivo }}</td>
                    <td><a href="{{ route('cargar_datos.show',$item->dbp_secuencial) }}" class="btn btn-info btn-xs"> 
                            <i class="fa fa-eye"></i> 
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        
</div>
@endsection
