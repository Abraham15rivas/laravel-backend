<?php

use Illuminate\Database\Seeder;
use App\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = ['admin', 'client'];
        foreach ($role as $rol) {
            Rol::create([
                'name' => $rol,
                'description' => 'role registrado'
            ]);
        }
    }
}
