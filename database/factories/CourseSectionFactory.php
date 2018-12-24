<?php

use Faker\Generator as Faker;

$courses = \App\Course::all()->pluck('id')->toArray();

$factory->define(\App\CourseSection::class, function (Faker $faker) use ($courses) {
    return [
        'name' => $faker->words(3, true),
        'details' => $faker->paragraph(10),
        'course_id' => $faker->randomElement($courses)
    ];
});
