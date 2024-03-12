@extends('layouts.app')
    @section('content')
        <div class="container-fluid">
                    <div class="panel panel-info text-center text-bolder">
                        <div class="panel-heading ">
                            ORDER GENERADA: {{ $sec }}
                        </div>
                        <div class="panel-body">
                            @include('pensiones.table_ver_ordenes')
                        </div>
                    </div>
        </div>
    @endsection

