<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Universidad;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {
    $uni = Universidad::first();

    $u1 = new User();
    $u1->nombre = 'Martín';
    $u1->email = 'martin@gmail.com';
    $u1->password = Hash::make('secret');
    $u1->universidad_id = $uni->id;
    $u1->save();

    $u2 = new User();
    $u2->nombre = 'Bryan';
    $u2->email = 'bryan@gmail.com';
    $u2->password = Hash::make('secret');
    $u2->universidad_id =  $uni->id;
    $u2->save();

    $u3 = new User();
    $u3->nombre = 'Liam';
    $u3->email = 'segundo@gmail.com';
    $u3->password = Hash::make('secret');
    $u3->universidad_id =  $uni->id;
    $u3->save();


  }
}
