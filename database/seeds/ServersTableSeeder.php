<?php

use Illuminate\Database\Seeder;
use App\Server;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Server::class, 50)->create();
    }
}
