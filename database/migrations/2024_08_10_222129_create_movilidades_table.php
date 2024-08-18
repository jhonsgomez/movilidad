<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movilidades', function (Blueprint $table) {
            $table->id();
            $table->boolean('nac_ext')->nullable(false);
            $table->unsignedBigInteger('convenio_id')->nullable(true);
            $table->boolean('ent_sal')->nullable(false);
            $table->string('documento', 20)->nullable(true)->nullable(false);
            $table->string('nombre')->nullable(false);
            $table->string('tipo_persona', 100)->nullable(false);
            $table->string('pais')->nullable(false);
            $table->string('actividad')->nullable(false);
            $table->boolean('pres_virt')->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->string('entidad')->nullable(false);
            $table->text('objeto')->nullable(false);
            $table->text('resultados')->nullable(false);
            $table->text('responsable')->nullable(true);
            $table->date('fecha_inicio')->nullable(false);
            $table->date('fecha_final')->nullable(false);
            $table->text('doc_soporte')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movilidades');
    }
};
