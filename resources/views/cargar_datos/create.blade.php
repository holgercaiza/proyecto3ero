@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info text-center text-bolder">
                <div class="panel-heading ">Seleccione el archivo </div>
                <div class="panel-body">
                    <form action="{{route('cargar_datos.store')}}" method="POST" enctype="multipart/form-data" >
                        {{csrf_field()}}
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="dpb_nombre_archivo">Archivo</label>
                            <input type="file" name="dpb_nombre_archivo" id="dpb_nombre_archivo">
                            <div style="margin-top:10px">
                                <button type="submit" class="btn btn-primary pull-left">Subir</button>
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