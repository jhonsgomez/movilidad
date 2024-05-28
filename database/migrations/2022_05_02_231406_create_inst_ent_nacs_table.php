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
        Schema::create('inst_ent_nacs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ciudad')->nullable();
            $table->string('nit', 12)->nullable();
            $table->bigInteger('telefono')->nullable();
            $table->string('email', 100);
            $table->string('docSoportes')->nullable();
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
        Schema::dropIfExists('inst_ent_nacs');
    }
};
