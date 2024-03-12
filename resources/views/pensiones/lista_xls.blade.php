<?php 
 $filename = "Reporte_pagos.xls";
  header("Pragma: public");
  header("Expires: 0");
  header("Content-type: application/vnd.ms-excel; name='excel'");
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pago de Pensiones</title>
</head>
<body>
    <img src="{{ asset('img/escudo.png') }}" style="width:50px !important" width="50px" alt="">
    <h3 style="text-align:center ;">REPORTE DE PAGO DE PENSIONES</h3>
    <h4>{{ $enc }}</h4>
    @include('pensiones._lst_table');

</body>
</html>
