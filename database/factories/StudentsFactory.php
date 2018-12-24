<?php

use Faker\Generator as Faker;

$student_groups = \App\StudentGroup::all()->pluck('id')->toArray();

$factory->define(\App\Student::class, function (Faker $faker) use ($student_groups) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->freeEmail,
        'student_group_id' => $faker->randomElement($student_groups)
    ];
});
