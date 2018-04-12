<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApunteComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apunte_comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('apunte_id');
            $table->string('texto');
            $table->smallInteger('positivos')->default(0);
            $table->smallInteger('negativos')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apunte_comentarios');
    }
}
