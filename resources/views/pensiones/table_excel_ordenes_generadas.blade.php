@php
$filename = "Ordenes.xls";
header("Pragma: public");
header("Expires: 0");
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");    
@endphp

<table class="table">
    @foreach ($datos as $d)
        <tr>
            <td>CO</td>
            <td>{{ $d->est_cedula}}</td>
            <td>USD</td>
            <td>{{ $d->valor_pagar}}</td>
            <td>REC</td>
            <td></td>
            <td></td>
            <td>{{ $d->codigo}}</td>
            <td>N</td>
        </tr>
    @endforeach
</table>