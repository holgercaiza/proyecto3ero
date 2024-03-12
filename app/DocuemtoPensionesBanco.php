<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocuemtoPensionesBanco extends Model
{
    //
    public $table = 'documento_pensiones_banco';
    protected $primaryKey='dpb_id';
    public $timestamps=false;

    protected $fillable = [
        'dpb_fecha_registro', 
        'dpb_fecha_pago', 
        'dpb_codigo',
        'dpb_concepto',
        'dpb_tipo',
        'dpb_documento',
        'dpb_oficina',
        'dpb_monto',
        'dpb_saldo',
        'dpb_monto',
        'dpb_estado',
        'dpb_nombre_archivo',
        'usr_id',
        'dbp_secuencial'
    ];  
    
}
