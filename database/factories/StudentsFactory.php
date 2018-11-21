<?php

use Faker\Generator as Faker;

$student_categories = \App\StudentCategory::all()->pluck('id')->toArray();
$student_groups = \App\StudentGroup::all()->pluck('id')->toArray();

$factory->define(\App\Student::class, function (Faker $faker) use ($student_categories, $student_groups) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->freeEmail,
        'student_category_id' => $faker->randomElement($student_categories),
        'student_group_id' => $faker->randomElement($student_groups)
    ];
});
