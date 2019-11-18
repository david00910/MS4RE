<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Property;
use App\PropertyCategories;
use Faker\Generator as Faker;

$factory->define(PropertyCategories::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence($nb = '3', $asText = false),
        'category' => $faker->word
    ];
});
