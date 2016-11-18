<?php
/**
 * Created by PhpStorm.
 * User: saramartinezbayo
 * Date: 25/5/16
 * Time: 17:15
 */

use \Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(array(
            "nombre" => "Cholo",
            "apellidos" => "Simeone",
            "email" => "simeone@simeone.com",
            "password" => \Hash::make('secret'),
            "activo" => 1,
            "rol" => "user"
        ));
        \DB::table('users')->insert(array(
            "nombre" => "Admin",
            "apellidos" => "Admin",
            "email" => "admin@admin.com",
            "password" => \Hash::make('admin1234'),
            "activo" => 1,
            "rol" => "admin"
        ));
    }
}