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
        Schema::create('institucion_entidad_ints', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('pais');
            $table->string('ciudad');
            $table->string('nit', 30)->nullable();
            $table->string('telefono')->nullable();
            $table->string('email');
            $table->tinyInteger('estado')->default(1);
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institucion_entidad_ints');
    }
};
