<?php

use Faker\Generator as Faker;
use App\Server;
$factory->define(Server::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'ip' => $faker->ipv4,
        'port' => $faker->numberBetween('1024','65535'),
        'user' => $faker->userName(),
        'pass' => $faker->password(),
        'authcode' => str_random(10),
    ];
});
