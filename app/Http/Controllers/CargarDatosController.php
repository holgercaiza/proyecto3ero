<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DocuemtoPensionesBanco;
use Illuminate\Support\Facades\Redirect;
use App\Pensiones;
use DB;
use Auth;
use Validator;

class CargarDatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function __construct() {


        $this->middleware(function ($request, $next) {
            $connection = session('suc_id');

            if ($connection == 1) {
                DB::setDefaultConnection('pgsql');
            } else {
                DB::setDefaultConnection('pgsql2');
            }

            return $next($request);
        });

    }     
     
     
    public function index()
    {
    
        //$databaseName = DB::connection()->getDatabaseName();
        
        $sql="SELECT dbp_secuencial,dpb_fecha_registro,dpb_nombre_archivo
        FROM documento_pensiones_banco 
        group by dbp_secuencial,dpb_fecha_registro,dpb_nombre_archivo
        order by dpb_fecha_registro desc ";
        $doc_pensiones_banco=DB::select($sql);

      return view('cargar_datos.index')
        ->with('doc_pensiones_banco',$doc_pensiones_banco);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('cargar_datos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function aniolectivo($periodo){
        $anl=DB::selectone("SELECT * from aniolectivo WHERE anl_selected=1 AND periodo=$periodo ORDER BY id DESC LIMIT 1 ");
        return $anl->id;
     }
     
    public function store(Request $request)
    {
        
       
        $anl=$this->aniolectivo(0);//Regular
        $anl_bgu=$this->aniolectivo(1);//BGU

        if ($request->hasFile('dpb_nombre_archivo')) {
            $file = $request->file('dpb_nombre_archivo');
            $folderPath = public_path('csv');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $fileName = $file->getClientOriginalName();
            $file->move($folderPath, $fileName);
            $csvData = file_get_contents($folderPath . '/' . $fileName);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            $header = array_shift($rows);
            $x = 0;
            $error = false;
        
            //DB::beginTransaction();
            $sec=DB::selectOne("SELECT max(dbp_secuencial) as sec FROM documento_pensiones_banco");
            if(empty($sec)){
                $nsec=1;
            }else{
                $nsec=$sec->sec+1;
            }

            try {
                
                foreach ($rows as $row) {
                    $x++;
                    if(count($row)==1){
                        $aux_row = str_replace('"', '', $row[0]);
                        $datos = str_getcsv($aux_row);
                    }else{
                        //$aux_row = str_replace('"', '', $row[0]);
                        $datos = $row;
                    }
                    if (isset($datos[1])) {
                        
                        $input['dpb_fecha_registro'] = date('Y-m-d');
                      
                        $auxFecha=explode("/",$datos[0]);
                        $input['dpb_fecha_pago'] = $auxFecha[2].'-'.$auxFecha[1].'-'.$auxFecha[0];

                      
                        $input['dpb_codigo'] = $datos[1];
                        $input['dpb_concepto'] = $datos[2];
                        $input['dpb_tipo'] = $datos[3];
                        $input['dpb_documento'] = $datos[4];
                        $input['dpb_oficina'] = $datos[5];
                        $input['dpb_monto'] = str_replace(',', '', $datos[6]);
                        $input['dpb_saldo'] = 0;
                        $input['dpb_nombre_archivo'] = $fileName;
                        $input['usr_id'] = Auth::user()->usr_id;
                        $input['dbp_secuencial']=$nsec;
                        // Validar los datos antes de la inserción
                        $validator = Validator::make($input, [
                            'dpb_fecha_pago' => 'required|date',
                            'dpb_codigo' => 'required',
                            'dpb_concepto' => 'required',
                            'dpb_tipo' => 'required',
                            'dpb_documento' => 'required',
                            'dpb_oficina' => 'required',
                            'dpb_monto' => 'required',
                            'dpb_saldo' => 'required',
                            'dpb_nombre_archivo' => 'required',
                            'usr_id' => 'required',
                        ]);
                        
      
                        // if ($validator->fails()) {
                        //     $error = true;
                        //     break;
                        // }
                        
                        $doc_pensiones_banco=DocuemtoPensionesBanco::create($input);
                        
                        $aux_doc=explode('-',$input['dpb_concepto']);
                        
                        if(isset($aux_doc[2])){
                            $cedula = preg_replace('/[^A-Za-z0-9]/', '', trim($aux_doc[2]));
                            $estudiante=DB::selectone("SELECT * FROM estudiantes e join matriculas m on e.id=m.est_id where e.est_cedula='$cedula' and (m.anl_id=$anl or m.anl_id=$anl_bgu ) order by m.id desc limit 1   ");
                            
                            if(!empty($estudiante)){
                            
                                    $mat_id=$estudiante->id;
                                    $sql="SELECT * from pago_pensiones where mat_id=$mat_id order by pag_id desc limit 1 ";
                                    $pagos=DB::selectone($sql);
                                    if(empty($pagos)){
                                        $new_mes_clave='MAT';
                                    }else{
                                        $mes = $this->meses()[$pagos->pag_pago];
                                        $mes = $mes + 1;
                                        if ($mes > 13) {
                                            $mes = $mes % 13;
                                        }
                                        $new_mes_valor = $mes;
                                        $new_mes_clave = array_search($new_mes_valor, $this->meses());
                                    }
                                    $inputp['pag_fecha']=$input['dpb_fecha_pago']; 
                                    $inputp['pag_descripcion']=$input['dpb_concepto']; 
                                    $inputp['pag_documento']=$input['dpb_documento'];
                                    $inputp['pag_valor']=$input['dpb_monto'];
                                    $inputp['pag_fecha_registro']=date('Y-m-d');
                                    $inputp['usr_id']=Auth::user()->usr_id;
                                    $inputp['mat_id']=$mat_id;
                                    //$inputp['pag_pago']='JUL';
                                    $inputp['pag_pago']=$new_mes_clave;
                                    $inputp['dpb_id']=$doc_pensiones_banco->dpb_id;  
                                    Pensiones::create($inputp);
                            }
                       
                        }
                        
                    }
                }
        
                if (!$error) {
                    //DB::commit();
                    //dd('Archivo subido y datos guardados exitosamente.');
                    return redirect()->back()->with('success', 'Archivo subido y datos guardados exitosamente.');
                } else {
                    //DB::rollBack();
                    //dd('Error en los datos del archivo. Por favor, verifica los campos requeridos.');
                    return redirect()->back()->with('error', 'Error en los datos del archivo. Por favor, verifica los campos requeridos.');
                }
            } catch (Exception $e) {
                //DB::rollBack();
                ///dd('Se produjo un error al procesar el archivo.');
                return redirect()->back()->with('error', 'Se produjo un error al procesar el archivo.');
            }
        }
        
        return redirect()->back()->with('error', 'No se seleccionó ningún archivo.');
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
     
    public function show($id)
    {
    
        $sql="SELECT pb.*,pp.pag_pago,e.est_apellidos,e.est_nombres,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelo FROM documento_pensiones_banco pb
        LEFT JOIN pago_pensiones pp on pb.dpb_id=pp.dpb_id
        LEFT JOIN matriculas m ON m.id=pp.mat_id
        LEFT JOIN estudiantes e ON e.id=m.est_id
        LEFT JOIN jornadas j ON j.id=m.jor_id
        LEFT JOIN especialidades es ON es.id=m.esp_id
        LEFT JOIN cursos c ON c.id=m.cur_id
        WHERE pb.dbp_secuencial=$id
        ORDER BY m.jor_id,m.esp_id,m.cur_id,m.mat_paralelo";
       
        $doc_pensiones_banco=DB::select($sql);
        
        
        return view('cargar_datos.show')
        ->with('doc_pensiones_banco',$doc_pensiones_banco)
        ;
        
        
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function elimina_registro_pago(request $request){

        DB::beginTransaction();
        
        try {
            $dt = $request->all();
            $dpb_id = $dt['dpb_id'];
            $documentos_pago = DocuemtoPensionesBanco::where('dpb_id', $dpb_id)->lockForUpdate()->first();
            if (!empty($documentos_pago)) {
                $documentos_pago->dpb_estado = 0;
                $documentos_pago->save();
        
                $pagos = Pensiones::where('dpb_id', $dpb_id)->get();
                if (!$pagos->isEmpty()) {
                    $pagos->each->delete();
                }
            }
        
            DB::commit();
            
            return Redirect::back();
            
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        
    }
    
    public function destroy($id)
    {
        dd($id);
    }
    
    public function meses(){
    
        return [
            'MAT'=>1,
            'SEP'=>2,
            'OCT'=>3,
            'NOV'=>4,
            'DIC'=>5,
            'ENE'=>6,
            'FEB'=>7,
            'MAR'=>8,
            'ABR'=>9,
            'MAY'=>10,
            'JUN'=>11,
            'JUL'=>12,
            'AGO'=>13
        ];
        
        }    
    
}
