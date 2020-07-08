<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ship;
use Faker\Generator as Faker;

$factory->define(Ship::class, function (Faker $faker) {
    return [
        'health' => 100,
        'attack' => 10,
        'defence' => 10
    ];
});

$factory->state(Ship::class, 'offensive', [
    'attack' => 15,
    'defence' => 5
]);

$factory->state(Ship::class, 'defensive', [
    'attack' => 5,
    'defence' => 15
]);

