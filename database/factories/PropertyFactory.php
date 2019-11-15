<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence($nb = '3', $asText = false),
        'price' => rand(1000000, 50000000),
        'brutto' => rand(1000000, 50000000),
        'netto' => rand(100000, 5000000),
        'own_exp' => rand(10000, 500000),
        'deposit' => rand(1000, 50000),
        'sqm_price' => rand(100, 5000),
    ];
});
