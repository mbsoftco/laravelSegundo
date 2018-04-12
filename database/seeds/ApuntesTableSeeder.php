<?php

use Illuminate\Database\Seeder;
use App\Apunte;
use App\User;
use App\Curso;
use App\Universidad;

class ApuntesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {

    $user = User::first();
    $curso = Curso::first();
    $universidad = Universidad::first();

    $apunte = new Apunte();
    $apunte->slug = 'examen-i';
    $apunte->nombre = 'Examen I';
    $apunte->user_id = $user->id;
    $apunte->curso_id = $curso->id;
    $apunte->universidad_id = $universidad->id;
    $apunte->docente = 'EL Profe';
    $apunte->ciclo = 'I - 2016';
    $apunte->tipo = 'Examen';
    $apunte->descripcion = 'Mel ut prima vivendo glóriatur, in vix lorem comprehensam. Mutat deleniti disputationi an eúm. Nostrud vocibus áncillae duo ea, saépe probatus abhórreant his at. Eu quo error fabellas interesset, labitur splendide te pri.';
    $apunte->archivos = 0;
    $apunte->save();

    $apunte2 = new Apunte();
    $apunte2->slug = 'monografia-administracion';
    $apunte2->nombre = 'Monografía Administración';
    $apunte2->user_id = $user->id;
    $apunte2->curso_id = $curso->id;
    $apunte2->universidad_id = $universidad->id;
    $apunte2->docente = 'MI Profe';
    $apunte2->ciclo = 'II - 2016';
    $apunte2->tipo = 'Monografía';
    $apunte2->descripcion = 'Mel ut prima vivendo glóriatur, in vix lorem comprehensam. Mutat deleniti disputationi an eúm. Nostrud vocibus áncillae duo ea, saépe probatus abhórreant his at. Eu quo error fabellas interesset, labitur splendide te pri.';
    $apunte2->archivos = 0;
    $apunte2->save();


  }
}
