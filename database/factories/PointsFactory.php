<?php

use Faker\Generator as Faker;

$enrollments = \App\CourseEnrollment::all();

$factory->define(App\Point::class, function (Faker $faker) {
    $enrollment = \App\CourseEnrollment::inRandomOrder()->first();
    $section = \App\CourseSection::where('course_id', $enrollment->course_id)->inRandomOrder()->first();
    $date = $faker->dateTimeBetween('-15 day', 'now');
    return [
        'course_id' => $enrollment->course_id,
        'course_enrollment_id' => $enrollment->id,
        'course_section_id' => $section->id,
        'student_id' => $enrollment->student_id,
        'student_group_id' => $enrollment->student->student_group_id,
        'points' => $faker->numberBetween(20, 100),
        'hours' => $faker->numberBetween(1, 3),
        'minutes' => $faker->numberBetween(0, 59),
        'created_at' => $date,
        'updated_at' => $date
    ];
});
