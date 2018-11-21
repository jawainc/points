<?php

use Illuminate\Database\Seeder;

class CourseSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseSection::class, 75)->create();
    }
}
