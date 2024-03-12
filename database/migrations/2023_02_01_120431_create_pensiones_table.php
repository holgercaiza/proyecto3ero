<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePensionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pago_pensiones', function (Blueprint $table) {
            $table->increments('pag_id');
            $table->unsignedInteger('usr_id');
            $table->unsignedInteger('mat_id');
            $table->foreign('usr_id')->references('usr_id')->on('usrpensiones');
            $table->foreign('mat_id')->references('id')->on('matriculas');
            $table->date('pag_fecha');
            $table->string('pag_descripcion');
            $table->string('pag_documento');
            $table->float('pag_valor');
            $table->date('pag_fecha_registro');
            $table->string('pag_pago');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('pago_pensiones');
    }
}
