<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsrPensionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('usrpensiones')->insert([
             'usr_usuario'=>'SuperAdmin ',
             'email'=>'spadmin@vn.com',
             'password'=>bcrypt('171402'),
             'created_at'=>date('Y-m-d')             
        ]); 

    }
}
