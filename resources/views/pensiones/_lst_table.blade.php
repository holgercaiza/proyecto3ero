                <table class="table">
                    <tr class="bg-info">
                        <th class="text-center" style="border:solid 1px #ccc;" >#</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >Estudiante</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >MAT</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >SEP</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >OCT</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >NOV</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >DIC</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >ENE</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >FEB</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >MAR</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >ABR</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >MAY</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >JUN</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >JUL</th>
                        <th class="text-center" style="border:solid 1px #ccc;" >AGO</th>
                    </tr>
                    @foreach($datos as $d)
                    <?php 
                    $dt=explode('&',$d->est);
                    $est=$dt[0];
                    ?>
                    <tr>
                        <td style="border:solid 1px #ccc;" >{{$loop->iteration}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px "  class="text-left">{{$est}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->mt}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->s}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->o}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->n}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->d}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->e}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->f}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->mz}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->a}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->my}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->j}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->jl}}</td>
                        <td style="border:solid 1px #ccc;font-size:11px " >{{$d->ag}}</td>
                    </tr>
                    @endforeach
                </table>
