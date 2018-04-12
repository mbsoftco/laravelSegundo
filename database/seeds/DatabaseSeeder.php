<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
	  // Role comes before User seeder here.
	  $this->call(AdminRolesTableSeeder::class);
	  // User seeder will use the roles above created.
	  $this->call(AdminTableSeeder::class);
	  // User seeder will use the roles above created.
	  $this->call(UniversidadesTableSeeder::class);
	  // User seeder will use the roles above created.
	  $this->call(UsersTableSeeder::class);
	  // User seeder will use the roles above created.
	  $this->call(CursosTableSeeder::class);
	  // User seeder will use the roles above created.
	  $this->call(ApuntesTableSeeder::class);
	}
}
