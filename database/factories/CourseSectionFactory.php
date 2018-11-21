<?php

use Faker\Generator as Faker;

$courses = \App\StudentCategory::all()->pluck('id')->toArray();

$factory->define(\App\CourseSection::class, function (Faker $faker) use ($courses) {
    return [
        'name' => $faker->words(2, true),
        'details' => $faker->paragraph(3),
        'course_id' => $faker->randomElement($courses)
    ];
});
