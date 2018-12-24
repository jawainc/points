<?php

use Faker\Generator as Faker;

$course_categories = \App\CourseCategory::all()->pluck('id')->toArray();
$factory->define(App\Course::class, function (Faker $faker) use ($course_categories) {
    return [
        'name' => $faker->words(2, true),
        'course_category_id' => $faker->randomElement($course_categories)
    ];
});
