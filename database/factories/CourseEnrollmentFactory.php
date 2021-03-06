<?php

use Faker\Generator as Faker;

$courses = \App\Course::all()->pluck('id')->toArray();
$students = \App\Student::all()->pluck('id')->toArray();
$factory->define(App\CourseEnrollment::class, function (Faker $faker) use ($courses, $students) {
    return [
        'course_id' => $faker->randomElement($courses),
        'student_id' => $faker->randomElement($students),
        'start_date' => $faker->date()
    ];
});
