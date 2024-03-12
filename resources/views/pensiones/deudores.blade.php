<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }
body { box-sizing: border-box;margin: 0 auto; overflow: hidden; padding: 0.5in;}
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

body { 
     width: 8.3in; 
     height:auto;
    }

    table{
       border-collapse: collapse;        
    }
    td{
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;       
        font-size:11px;
        border-bottom:dashed 1px #ccc;  
    }
    th{
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;       
        font-size:12px; 
        border-bottom:dashed 1px #ccc;  
    }

@media all {
   .saltopagina{
      display: none;
   }
}
   
@media print{

    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }

   .saltopagina{
      display:block;
      page-break-before:always;
   }
}     
@page { margin:1;}
</style>

</head>
<body>
            <div class="container" style="width:100% !important" >
                <div class="row">
                    <h3 class="text-center">REPORTE DE DEUDORES</h3>
                    <h4> <small class="pull-right">{{ 'Impreso: '.date('Y-m-d H:i') }}</small> </h4>
                </div>
                <?php 
                $est="";
                $x=1;
                ?>
                @foreach($deudores as $p)
                @if($est!=$p['est_apellidos'])
                <div class="row">
                    <div class="col-md-12 text-center">{{ $x }} {{ $p['est_apellidos'] }} {{ $p['est_nombres'] }}</div>
                    <div class="col-md-12"><small>{{ $p['jor_descripcion'].' / '.$p['cur_descripcion'].' / '.$p['mat_paralelo'] }} </small></div>
                </div>
                <div class="row bg-info" style="margin:0px 5px 0px 5px;">
                    <div class="col-md-2">Fecha</div>
                    <div class="col-md-5">Descripcion</div>
                    <div class="col-md-2">Documento</div>
                    <div class="col-md-1">Valor</div>
                    <div class="col-md-1">Pago</div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-5 text-left"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">{{ $p['pag_pago'] }}</div>
                </div>
                <?php 
                    $est=$p['est_apellidos'];
                    $x++;
                ?>
                @else
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-5 text-left"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">{{ $p['pag_pago'] }}</div>
                </div>
                @endif
                @endforeach

            </div>
    
</body>
</html>