<table class="table">
    <tr>
        <th colspan="2"></th>
        <th colspan="{{ count($rubros_tmp)-13 }}" class="text-center bg-info" >RUBROS</th>
        <th colspan="13" class="text-center bg-warning">Pensiones</th>
    </tr>
    <tr class="bg-info">
        <th class="text-center" style="border:solid 1px #ccc;" >#</th>
        <th class="text-center" style="border:solid 1px #ccc;" >Estudiante</th>
        @foreach($rubros_tmp as $rt)
            <th class="text-center" style="border:solid 1px #ccc;" >{{ $rt->rubro }}</th>
        @endforeach
        
    </tr>
    @foreach($datos as $d)
    <tr>
        <td style="border:solid 1px #ccc;" >{{$loop->iteration}}</td>
        <td style="border:solid 1px #ccc;font-size:11px "  class="text-left">{{$d->estudiante}}</td>
        @foreach($rubros_tmp as $rt)
        <?php 
            $rb=strtolower($rt->rubro);
        ?>
        <th class="text-center" style="border:solid 1px #ccc;" >{{ $d->$rb }}</th>
        @endforeach
    </tr>
    @endforeach
</table>
