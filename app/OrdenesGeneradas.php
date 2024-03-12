<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenesGeneradas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordenes_generadas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ord_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mat_id',
        'codigo',
        'fecha_registro',
        'valor_pagar',
        'fecha_pago',
        'valor_pagado',
        'estado',
        'mes',
        'responsable',
        'secuencial',
        'documento',
    ];

    /**
     * Get the matricula associated with the orden generada.
     */
    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'mat_id', 'id');
    }
    
}