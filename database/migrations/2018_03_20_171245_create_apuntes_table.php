<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApuntesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apuntes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('curso_id');
            $table->integer('universidad_id');
            $table->string('nombre');
            $table->string('slug', 140)->unique();
            $table->string('thumbnail')->nullable();
            $table->string('docente');
            $table->string('ciclo');
            $table->enum('tipo', array('Monografía', 'Trabajo Grupal', 'Examen', 'Examen Calificado', 'Tarea'));
            $table->text('descripcion');
            $table->smallInteger('comentarios')->default(0);
            $table->smallInteger('positivos')->default(0);
            $table->smallInteger('negativos')->default(0);
            $table->tinyInteger('archivos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apuntes');
    }
}
