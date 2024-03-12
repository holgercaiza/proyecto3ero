<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Session;

class Pensiones extends Model
{

    public $table = 'pago_pensiones';
    protected $primaryKey='pag_id';
    public $timestamps=false;

    protected $fillable = [
        'pag_fecha', 
        'pag_descripcion', 
        'pag_documento',
        'pag_valor',
        'pag_fecha_registro',
        'usr_id',
        'mat_id',
        'pag_pago',
        'dpb_id'
    ];  

    public function getConnectionName()
    {
        if (Session::get('suc_id') != 1) {
            return 'pgsql2';
        }
        return $this->connection;
    }      

}
