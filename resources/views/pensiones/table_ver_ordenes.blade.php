<table class="table">
    <tr>
        <th>#</th>
        <th>Cedula</th>
        <th>Estudiante</th>
        <th>Valor a Pagar</th>
        <th>Jorna/Curso/Paralelo</th>
        <th>Fecha Pago</th>
        <th>Valor Pagado</th>
        <th>Documento</th>
        <th>Estado</th>
    </tr>
    @foreach ($datos as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->est_cedula}}</td>
            <td class="text-left">{{ $d->est_apellidos.' '.$d->est_nombres }}</td>
            <td class="text-left">{{ $d->jor_descripcion.' '.$d->esp_descripcion.' '.$d->cur_descripcion.' '.$d->mat_paralelot}}</td>
            <td>{{ $d->valor_pagar}}</td>
            <td>{{ $d->fecha_pago}}</td>
            <td>{{ $d->valor_pagado}}</td>
            <td>{{ $d->documento}}</td>
            <td>{{ $d->estado==0?'Pendiente':'Pagado'}}</td>
        </tr>
    @endforeach
</table>