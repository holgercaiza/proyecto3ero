<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Pensiones;
use App\OrdenesGeneradas;
use DB;
use Auth;
use Session;
class PensionesController extends Controller
{

    private $campus;

    public function __construct() {


        $this->middleware(function ($request, $next) {
            $connection = session('suc_id');

            if ($connection == 1) {
                DB::setDefaultConnection('pgsql');
                $this->campus='G'; ///Guamaní
            } else {
                DB::setDefaultConnection('pgsql2');
                $this->campus='C'; ///Cojimies
            }

            return $next($request);
        });

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $rq)
    {
    
        $dt=$rq->all();
        $desde=date('Y-m-d');
        $hasta=date('Y-m-d');
        if(isset($dt['btn_buscar'])=='btn_buscar' ){
            $desde=$dt['desde'];
            $hasta=$dt['hasta'];
        }

        $sql="
        SELECT p.*,e.est_apellidos,e.est_nombres,e.est_cedula,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelo,m.id as mat_id,a.anl_descripcion 
        FROM pago_pensiones p 
        JOIN matriculas m on m.id=p.mat_id 
        JOIN estudiantes e on m.est_id=e.id 
        JOIN aniolectivo a on m.anl_id=a.id 
        JOIN jornadas j on m.jor_id=j.id 
        JOIN especialidades es on m.jor_id=es.id 
        JOIN cursos c on m.cur_id=c.id 
        WHERE p.pag_fecha_registro between '$desde' and '$hasta'
        AND m.mat_estado=1
        order by e.est_apellidos ";
        $pensiones=DB::select($sql);

        return view('pensiones.index')
        ->with('pensiones',$pensiones)
        ->with('desde',$desde)
        ->with('hasta',$hasta)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pensiones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dt=$request->all();
        $dt['usr_id']=Auth::user()->usr_id;
        $dt['pag_fecha_registro']=date('Y-m-d');
        Pensiones::create($dt);
        return redirect(route('pensiones.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = URL::previous();
        $aux_url=explode('/',$url);
        $last_url=($aux_url[count($aux_url)-1]);
        $op=0;
        if($last_url=='reportes'){
            $op=1;
        }

        $sql="SELECT p.*,e.est_apellidos,
        e.est_nombres,
        e.est_cedula,
        j.jor_descripcion,
        es.esp_descripcion,
        c.cur_descripcion,
        m.mat_paralelo,
        m.id as mat_id,
        a.anl_descripcion 
            FROM pago_pensiones p 
            JOIN matriculas m on m.id=p.mat_id 
            JOIN estudiantes e on m.est_id=e.id 
            JOIN aniolectivo a on m.anl_id=a.id 
            JOIN jornadas j on m.jor_id=j.id 
            JOIN especialidades es on m.esp_id=es.id 
            JOIN cursos c on m.cur_id=c.id
            WHERE p.pag_id=$id AND m.mat_estado=1";

            $pensiones=DB::select($sql);

        return view('pensiones.edit')
        ->with('ps',$pensiones[0])
        ->with('op',$op)
        ;


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dt=$request->all();
        $pensiones=Pensiones::find($id);
        $dt['usu_id']=Auth::user()->id;
        if(empty($pensiones->pag_fecha_registro)){
            $dt['pag_fecha_registro']=date('Y-m-d');
        }
        $pensiones->update($dt);
        if($dt['op']==0){
            return redirect(route('pensiones.index'));
        }else{
            return redirect(route('reportes'));
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pensiones=Pensiones::find($id);
        $pensiones->delete();
        return redirect(route('pensiones.index'));
    }
    public function search_student(Request $rq){
        $dt=$rq->all();
        $est_id= strtoupper($dt['est_id']);

        $sql=("SELECT e.est_apellidos,e.est_nombres,e.est_cedula,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelo,m.id as mat_id,a.anl_descripcion 
                                FROM estudiantes e 
                                JOIN matriculas m on m.est_id=e.id 
                                JOIN aniolectivo a on m.anl_id=a.id 
                                JOIN jornadas j on m.jor_id=j.id 
                                JOIN especialidades es on m.jor_id=es.id 
                                JOIN cursos c on m.cur_id=c.id 
                                WHERE a.anl_selected=1
                                AND m.mat_estado=1 
                                and (e.est_apellidos like '%$est_id%' or e.est_cedula like '%$est_id%' )                                  
                                ");
        $estudiante=DB::select($sql);
        return Response()->json($estudiante);

    }

    public function reportes(Request $rq){
        $dt=$rq->all();
        $pensiones=[];
        if(isset($dt['btn_buscar_deudores']) &&  $dt['btn_buscar_deudores']=='btn_buscar_deudores'){
            return $this->deudores($dt);
        }
        if(isset($dt['btn_buscar_deudores']) &&  $dt['btn_buscar_deudores']=='btn_deudores_lista' ){
            return $this->deudores_lista($dt,0);
        }

        if(isset($dt['btn_buscar_deudores']) &&  $dt['btn_buscar_deudores']=='imprimible' ){

            if($dt['jor_id']==1){
                $jor="MATUTINA";
            }else{
                $jor="SEMI-PRESENCIAL";
            }
            if($dt['esp_id']==10){
                $esp="-";
            }
            if($dt['esp_id']==8){
                $esp="BASICA FLEXIBLE";
            }
            if($dt['esp_id']==7){
                $esp="BGU";
            }

            $sql_curso=("SELECT * FROM cursos where id=".$dt['cur_id']);

            $curso=DB::select($sql_curso);

            $cur=$curso[0]->cur_descripcion;
            $enc=$jor." ".$esp." ".$cur." ".$dt['paralelo'];

            $datos=$this->deudores_lista_sql($dt);
            return view('pensiones.lista_print')
            ->with('datos',$datos)
            ->with('enc',$enc) ;
        }

        if(isset($dt['btn_buscar_deudores']) &&  $dt['btn_buscar_deudores']=='exportable' ){
        

            $enc=$this->encabezado_imprimibles($dt);
            
            
            $datos=$this->deudores_lista_sql($dt);
            return view('pensiones.lista_xls')
            ->with('datos',$datos)
            ->with('enc',$enc);
        }
        
        if(isset($dt['btn_buscar_deudores_consolidado'])){
        
            $enc=$this->encabezado_imprimibles($dt);
            
            // Obtenemos los datos recibidos desde la vista
            $anl_id = $dt['anl_id'];
            $jor_id = $dt['jor_id'];
            $esp_id = $dt['esp_id'];
            $cur_id = $dt['cur_id'];
            $paralelo = $dt['paralelo'];
            $mes = $dt['mes'];

            // Determinamos la condición para el filtro de especialidades en la consulta SQL
            if ($esp_id == 10) {
                $sql_esp = "";
            } elseif ($esp_id == 7 || $esp_id == 8) {
                $sql_esp = "AND m.esp_id=$esp_id";
            }

            // Consulta SQL para obtener datos de estudiantes y matrículas
            $sql = "SELECT *, m.id as mat_id FROM estudiantes e
                    JOIN matriculas m ON e.id = m.est_id 
                    JOIN jornadas j ON m.jor_id = j.id
                    JOIN especialidades es ON m.esp_id = es.id
                    JOIN cursos c ON m.cur_id = c.id
                    WHERE m.anl_id = $anl_id
                    AND m.jor_id = $jor_id
                    $sql_esp
                    AND m.cur_id = $cur_id
                    AND m.mat_paralelo = '$paralelo' 
                    AND m.mat_estado = 1 ";

            $estudiantes = DB::select($sql);

            // Consulta SQL para obtener datos de rubros de cursos específicos
            $sql_curso = $this->sql_cursos_rubros($cur_id);
            $rubros = DB::select("SELECT * FROM rubros WHERE rub_estado = 0 $sql_curso");

            $meses = $this->meses();

            // Limpiamos la tabla temporal antes de insertar nuevos datos
            $this->limpiar_tabla_temporales();

            // Iteramos sobre los estudiantes y los rubros para obtener información de pagos y luego insertar los datos en la tabla temporal
            foreach ($estudiantes as $estudiante) {
                $persona = $estudiante->est_apellidos . " " . $estudiante->est_nombres;

                foreach ($rubros as $rubro) {
                    $rubroCurso = $rubro->rub_siglas;
                    $valor = 0;
                    $mes = 0;
                    $documento = "";
                    $pagos = DB::selectone("SELECT * FROM pago_rubros WHERE rub_id = $rubro->rub_id AND per_id = $estudiante->mat_id");

                    if (!empty($pagos)) {
                        $valor = $pagos->pgr_monto;
                        $documento = $pagos->pgr_documento;
                    }

                    $this->insertar_datos_temporales($persona, $rubroCurso, $valor, $mes, $documento);
                }

                foreach ($meses as $key => $mesPago) {
                    $rubroMes = $mesPago;
                    $mes = $key;
                    $valor = 0;
                    $documento = "";
                    $pagos = DB::selectone("SELECT * FROM pago_pensiones WHERE pag_pago = '$rubroMes' AND mat_id = $estudiante->mat_id");

                    if (!empty($pagos)) {
                        $valor = $pagos->pag_valor;
                        $documento = $pagos->pag_documento;
                    }
                    $this->insertar_datos_temporales($persona, $rubroMes, $valor, $mes, $documento);
                }
                
            }
            
            $head=$this->encabezado_cross_rubros();
            
            $sql_cross="SELECT * FROM crosstab(
                'SELECT persona, rubro,
                    CASE 
                        WHEN valor > 0 THEN concat(documento,'' ('',valor,''$)'')
                        ELSE documento
                    END as valor
                FROM tmp_pagos
                ORDER BY 1, 2;
                ',            
                '$head[0]'
              ) AS ct(estudiante text, $head[1]); ";
            //dd($sql_cross);
            $datos=DB::select($sql_cross);
            $rubros_tmp=$this->rubro_tabla_temporal();
            if($dt['btn_buscar_deudores_consolidado']=='btn_deudores_consolidado'){
                $op=0;
            }
            if($dt['btn_buscar_deudores_consolidado']=='imprimible'){
                $op=1;
            }
            if($dt['btn_buscar_deudores_consolidado']=='exportable'){
                $op=2;
            }
            
            return view('pensiones.reporte_consolidado')
            ->with('datos',$datos)
            ->with('dt',$dt)
            ->with('op',$op)
            ->with('enc',$enc)
            ->with('rubros_tmp',$rubros_tmp)
            ;
            
            
        
        }
        if(isset($dt['btn_buscar'])=='btn_buscar'){
        
            $jor=$dt['jor_id'];
            $esp=$dt['esp_id'];
            $cur=$dt['cur_id'];
            $paralelo=$dt['paralelo'];
            $sql_esp="";
            $anl=$dt['anl_id'];
            if($esp!=10){ 
                $sql_esp="AND m.esp_id=$esp";
            }
            
            $sql="SELECT p.*,e.est_apellidos,e.est_nombres,e.est_cedula,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelo,m.id as mat_id,a.anl_descripcion 
            FROM pago_pensiones p 
            JOIN matriculas m on m.id=p.mat_id 
            JOIN estudiantes e on m.est_id=e.id 
            JOIN aniolectivo a on m.anl_id=a.id 
            JOIN jornadas j on m.jor_id=j.id
            JOIN especialidades es on m.esp_id=es.id
            JOIN cursos c on m.cur_id=c.id
            WHERE m.jor_id=$jor
            AND m.cur_id=$cur
            $sql_esp
            AND m.mat_paralelo='$paralelo'
            AND m.mat_estado=1
            AND m.anl_id=$anl
            ORDER BY e.est_apellidos,m.id,p.pag_id";
            $pensiones=DB::select($sql);
        
        }

        $anios=$this->periodos_lectivos();

        return view('pensiones.reportes')
        ->with('pensiones',$pensiones)
        ->with('dt',$dt)
        ->with('anios',$anios);
        
    }
    
    public function encabezado_imprimibles($dt){
    
        if($dt['jor_id']==1){
            $jor="MATUTINA";
        }else{
            $jor="SEMI-PRESENCIAL";
        }
        
        if($dt['esp_id']==10){
            $esp="-";
        }
        
        if($dt['esp_id']==8){
            $esp="BASICA FLEXIBLE";
        }
        
        if($dt['esp_id']==7){
            $esp="BGU";
        }
        
        $curso=DB::select("SELECT * FROM cursos where id=".$dt['cur_id']);
        $cur=$curso[0]->cur_descripcion;
        $enc=$jor." ".$esp." ".$cur." ".$dt['paralelo'];    
    
        return $enc;
    
    }
    
    public function rubro_tabla_temporal(){
        $rubros=DB::select("(SELECT DISTINCT tm.rubro,tm.mes,r.rub_descripcion FROM tmp_pagos tm JOIN rubros r ON tm.rubro=r.rub_siglas where tm.mes=0 ORDER BY 1)
        UNION ALL
       (SELECT DISTINCT rubro,mes,'' FROM tmp_pagos where mes<>0 ORDER BY mes )");
        return $rubros;
    }
    
    public function encabezado_cross_rubros(){
        $rubros=$this->rubro_tabla_temporal();
        $head1="";
        $head2="";
        $x=0;
        foreach($rubros as $r){
            $x++;
            if($x==count($rubros)){
                $head1.="SELECT cast("."''".$r->rubro."''"." as text)";
            }else{
                $head1.="SELECT cast("."''".$r->rubro."''"." as text) union all ";

            }
            
            $head2.=" {$r->rubro} text,"; 
        }
        $head2 = substr($head2, 0, strlen($head2) - 1);
        return [$head1,$head2];
        
    }
    
    public function limpiar_tabla_temporales(){
        DB::select("TRUNCATE TABLE tmp_pagos");
    }
    
    public function insertar_datos_temporales($persona,$rubro,$valor,$mes,$documento){
        $sql="INSERT INTO tmp_pagos (persona,rubro,valor,mes,documento)VALUES ('$persona','$rubro',$valor,$mes,'$documento') ";
        DB::select($sql);
        
    }
    
    public function sql_cursos_rubros($cur_id){
         $sql_cur="";
         if($cur_id==1){
            $sql_cur="AND c8=true";
         }
         if($cur_id==2){
            $sql_cur="AND c9=true";
         }
         if($cur_id==3){
            $sql_cur="AND c10=true";
         }
         if($cur_id==4){
            $sql_cur="AND c1=true";
         }
         if($cur_id==5){
            $sql_cur="AND c2=true";
         }
         if($cur_id==6){
            $sql_cur="AND c3=true";
         }
         return $sql_cur;
         
    }
    
    
    public function periodos_lectivos()
    {
        $sql=("SELECT * FROM aniolectivo where id>=16 order by periodo desc,id ");
        $periodos=DB::select($sql);
        return $periodos;
    }
    
    public function deudores($dt){
    
            $jor=$dt['jor_id'];
            $cur=$dt['cur_id'];
            $esp=$dt['esp_id'];
            $paralelo=$dt['paralelo'];
            $mes=$dt['mes'];

            $sql_esp="";
            $anl=$dt['anl_id'];
            
            if($esp!=10){ ///SOLO SE FILTRA BGU BASICA FLEXIBLE 
                $sql_esp="AND m.esp_id=$esp";
            }
            
            $sql="SELECT e.est_apellidos,e.est_nombres,e.est_cedula,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelo,m.id as mat_id,a.anl_descripcion 
            FROM matriculas m 
            JOIN estudiantes e on m.est_id=e.id 
            JOIN aniolectivo a on m.anl_id=a.id 
            JOIN jornadas j on m.jor_id=j.id 
            JOIN especialidades es on m.esp_id=es.id 
            JOIN cursos c on m.cur_id=c.id 
            WHERE m.jor_id=$jor
            AND m.cur_id=$cur
            $sql_esp
            AND m.mat_paralelo='$paralelo'
            AND m.mat_estado=1
            AND m.anl_id=$anl
            ORDER BY e.est_apellidos";

            $estudiantes=DB::select($sql);

            $meses=$this->meses();
            $key = array_search($mes, $meses);
            $deudores=[];
            foreach($estudiantes as $e){
                $x=0;
                foreach ($meses as $m){
                    $x++;
                     if($x<=$key){

                        $sql=("SELECT * FROM pago_pensiones WHERE mat_id=$e->mat_id and pag_pago='$m' ");

                            $pagos=DB::select($sql);

                        if(empty($pagos)){
                            array_push($deudores,['est_cedula'=>$e->est_cedula,
                                'est_apellidos'=>$e->est_apellidos,
                                'est_nombres'=>$e->est_nombres,
                                'jor_descripcion'=>$e->jor_descripcion,
                                'cur_descripcion'=>$e->cur_descripcion,
                                'mat_paralelo'=>$e->mat_paralelo,
                                'pag_pago'=>$m]);
                        }

                     }
                }
            }

            return view("pensiones.deudores")
            ->with('deudores',$deudores)
            ->with('mes',$mes)
            ;
    }

    public function deudores_lista($dt,$op){
          
           $datos=$this->deudores_lista_sql($dt);

            return view('pensiones.lista')
            ->with('datos',$datos)
            ->with('dt',$dt)
            ->with('op',$op)
            ;

    }
    public function deudores_lista_sql($dt){
            $jor=$dt['jor_id'];
            $cur=$dt['cur_id'];
            $esp=$dt['esp_id'];
            $paralelo=$dt['paralelo'];
            $mes=$dt['mes'];
            $sql_esp="";
            $anl=$dt['anl_id'];
            if($esp!=10){ ///SOLO SE FILTRA BGU BASICA FLEXIBLE 
                $sql_esp="AND m.esp_id=$esp";
                // if($esp==7){
                //     $anl=17;
                // }
            }
            $sql="SELECT * FROM crosstab('select e.est_apellidos|| '' '' ||e.est_nombres ,op.pag_pago ,op.pag_documento as mes
                from matriculas m 
                join estudiantes e on e.id=m.est_id
                join cursos c on c.id=m.cur_id
                left join pago_pensiones op on m.id=op.mat_id 
                where m.anl_id=$anl
                and m.jor_id=$jor
                and m.cur_id=$cur
                and m.mat_paralelo=''$paralelo''
                and m.mat_estado=1
                group by e.est_apellidos,e.est_nombres,m.jor_id,m.cur_id,e.rep_telefono,op.pag_documento,op.pag_pago
                order by e.est_apellidos
                '::text, '(select ''MAT'' as mes)
                union all
                (select ''SEP'' as mes)
                union all
                (select ''OCT'' as mes)
                union all
                (select ''NOV'' as mes)
                union all
                (select ''DIC'' as mes)
                union all
                (select ''ENE'' as mes)            
                union all
                (select ''FEB'' as mes)            
                union all
                (select ''MAR'' as mes)            
                union all
                (select ''ABR'' as mes)            
                union all
                (select ''MAY'' as mes)            
                union all
                (select ''JUN'' as mes)            
                union all
                (select ''JUL'' as mes)            
                union all
                (select ''AGO'' as mes)
                '::text) crosstab(est text,mt text,s text, o text, n text, d text, e text, f text, mz text, a text, my text, j text, jl text, ag text);";
                 $datos=DB::select($sql);
                return $datos;

    }

    public function meses(){
        return [
            '1'=>'MAT',
            '2'=>'SEP',
            '3'=>'OCT',
            '4'=>'NOV',
            '5'=>'DIC',
            '6'=>'ENE',
            '7'=>'FEB',
            '8'=>'MAR',
            '9'=>'ABR',
            '10'=>'MAY',
            '11'=>'JUN',
            '12'=>'JUL',
            '13'=>'AGO'
        ];
    }

    public function generar_ordenes(Request $rq){
        
        $dt=$rq->all();

        $periodos=DB::select("SELECT * FROM aniolectivo where id>17 order by id");
        $ordenes_generadas=DB::select("SELECT al.anl_descripcion,j.jor_descripcion,og.secuencial,og.mes,og.fecha_registro FROM ordenes_generadas og 
        JOIN matriculas m ON og.mat_id=m.id
        JOIN jornadas j ON m.jor_id=j.id
        JOIN aniolectivo al ON m.anl_id=al.id
        group by al.anl_descripcion,j.jor_descripcion,og.secuencial,og.mes,og.fecha_registro ");

        if(!empty($dt)){
            $anl_id=$dt['anl_id'];
            $jor_id=$dt['jor_id'];
            $esp_id=$dt['esp_id'];
            $mes=$dt['mes'];
            $estudiantes=$this->estudiantesJornada($anl_id,$jor_id,$esp_id);
            if(!empty($estudiantes)){
                $this->generaOrden($estudiantes,$mes,$jor_id,$esp_id);
            }
            
        }
        
        return view('pensiones.generar_ordenes')
        ->with('periodos',$periodos)
        ->with('ordenes_generadas',$ordenes_generadas)
        ;
        
    }
    
    public function estudiantesJornada($anl_id,$jor_id,$esp_id){
        $sql = "SELECT *, m.id as mat_id FROM estudiantes e
                JOIN matriculas m ON e.id = m.est_id 
                JOIN jornadas j ON m.jor_id = j.id
                JOIN especialidades es ON m.esp_id = es.id
                JOIN cursos c ON m.cur_id = c.id
                WHERE m.anl_id = $anl_id
                AND m.jor_id = $jor_id 
                AND m.mat_estado=1 ";
        $result=DB::select($sql);
       return  $result;  
    }

    public function generaOrden($estudiantes,$mes,$jor_id,$esp_id){

        $campus=$this->campus;
        $responsable=Auth::user()->usr_usuario;
        $numMes=$this->mesNumero($mes);
        $secuencial=DB::selectone("SELECT max(secuencial) AS secuencial FROM ordenes_generadas");
        $sec=1;
        if(!empty($secuencial)){
            $sec=$secuencial->secuencial+1;
        }

        switch($jor_id){
            case 1: 
                $jor='M'; 
                $valor_pagar=75; 
                break;
            case 3: 
                $jor='SM'; 
                $valor_pagar=55; 
            break;
        }

        foreach($estudiantes as $a){

            $esp=$a->esp_obs;
            if($esp_id==7){
                $esp='BGU';
            }
            if($esp_id==8){
                $esp='BX';
            }
            $codigo=$mes.$campus.$jor.$esp.'-'.$a->mat_id;
            $input=[
                'mat_id'=>$a->mat_id,
                'codigo'=>$codigo,
                'fecha_registro'=>date('Y-m-d'),
                'valor_pagar'=>$valor_pagar,
                'estado'=>0,
                'mes'=>$numMes,
                'responsable'=>$responsable,
                'secuencial'=>$sec
            ];
            
            OrdenesGeneradas::create($input);

        }

    }
        public function mesNumero($mes){

            $rst="";

            switch ($mes){

                case 'MT': $rst=0;  break;
                case 'S': $rst=1;  break;
                case 'O': $rst=2;  break;
                case 'N': $rst=3;  break;
                case 'D': $rst=4;  break;
                case 'E': $rst=5;  break;
                case 'F': $rst=6;  break;
                case 'M': $rst=7;  break;
                case 'A': $rst=8;  break;
                case 'MY': $rst=9;  break;
                case 'J': $rst=10;  break;
                case 'JL': $rst=11;  break;
                case 'AG': $rst=12;  break;

            }

            return $rst;

        }

        public function ver_ordenes_generadas($sec){
            
            $datos=$this->ordenes_generadas_por_secuencial($sec);
            return view('pensiones.ver_ordenes_generadas')
            ->with('sec',$sec)
            ->with('datos',$datos);
            
        }
        
        public function ordenes_generadas_por_secuencial($sec){

            $sql="SELECT * FROM ordenes_generadas og 
                JOIN matriculas m ON og.mat_id=m.id
                JOIN jornadas j ON m.jor_id=j.id
                JOIN aniolectivo al ON m.anl_id=al.id 
                JOIN estudiantes es ON m.est_id=es.id
                JOIN cursos c ON m.cur_id=c.id
                JOIN especialidades esp ON m.esp_id=esp.id
                WHERE og.secuencial=$sec
                ORDER by es.est_apellidos
            ";
            return DB::select($sql);            

        }
        public function excel_ordenes_generadas($sec){
            
            $datos=$this->ordenes_generadas_por_secuencial($sec);
            return view('pensiones.table_excel_ordenes_generadas')
            ->with('sec',$sec)
            ->with('datos',$datos);
            
        }
        
        public function elimina_ordenes_generadas(Request $rq){
            $dt=$rq->all();
            $sec=$dt['secuencial'];
            DB::select("DELETE FROM ordenes_generadas where secuencial=$sec ");
            return redirect(route('generar_ordenes'));
        }
        


}
