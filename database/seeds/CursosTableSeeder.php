<?php

use Illuminate\Database\Seeder;
use App\Curso;
use App\Universidad;

class CursosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {

    $uni = Universidad::first();

    $curso = new Curso();
    $curso->slug = 'administracion-i';
    $curso->nombre = 'Administración I';
    $curso->universidad_id = $uni->id;
    $curso->save();

    $curso2 = new Curso();
    $curso2->slug = 'administracion-ii';
    $curso2->nombre = 'Administración II';
    $curso2->universidad_id = $uni->id;
    $curso2->save();


  }
}
