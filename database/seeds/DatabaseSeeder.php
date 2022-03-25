<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     *
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TramDependenciaTableSeeder::class);
        $this->call(ActividadTableSeeder::class);
        $this->call(UbigeoTableSeeder::class);
        if (env("APP_ENV") == 'local') {
            $this->call(ProyectoTableSeeder::class);
        }
    }
}
