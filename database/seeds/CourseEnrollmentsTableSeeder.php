<?php

use Illuminate\Database\Seeder;

class CourseEnrollmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseEnrollment::class, 20)->create();
    }
}
