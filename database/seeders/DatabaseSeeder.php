<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
               'email'=>'herni.irawan@mail.com',
               'username'=>'herni123',
               'password'=> bcrypt('123456'),
            ]
        ];
  
        foreach ($userData as $key => $val) {
            DB::table('users_tb')->insert($val);
        }
    }
}
