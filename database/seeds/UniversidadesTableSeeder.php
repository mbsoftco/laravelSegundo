<?php

use Illuminate\Database\Seeder;
use App\Universidad;

class UniversidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {

    $uni1 = new Universidad();
    $uni1->slug = 'universidad-catolica-del-peru';
    $uni1->nombre = 'Universidad Católica del Perú';
    $uni1->nombre_corto = 'PUCP';
    $uni1->save();

    $uni2 = new Universidad();
    $uni2->slug = 'universidad-peruana-de-ciencias';
    $uni2->nombre = 'Universidad Peruana de Ciencias';
    $uni2->nombre_corto = 'UPC';
    $uni2->save();

    $uni3 = new Universidad();
    $uni3->slug = 'universidad-san-ignacio-de-loyola';
    $uni3->nombre = 'Universidad San Ignacio de Loyola';
    $uni3->nombre_corto = 'USIL';
    $uni3->save();

  }
}
