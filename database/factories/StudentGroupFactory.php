<?php

use Faker\Generator as Faker;

$factory->define(\App\StudentGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
