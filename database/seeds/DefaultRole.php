<?php

use Illuminate\Database\Seeder;

class DefaultRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => '默认用户组'
        ]);
    }
}
