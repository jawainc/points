<?php

use Illuminate\Database\Seeder;

class CourseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseCategory::class, 5)->create();
    }
}
