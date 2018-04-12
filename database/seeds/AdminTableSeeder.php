<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\AdminRoles;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {
    $role_admin = AdminRoles::where('name', 'admin')->first();

    $admin = new Admin();
    $admin->name = 'Administrador';
    $admin->email = 'admin@example.com';
    $admin->password = bcrypt('secret');
    $admin->save();
    $admin->roles()->attach($role_admin);

  }
}
