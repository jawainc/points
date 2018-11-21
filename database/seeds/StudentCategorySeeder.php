<?php

use Illuminate\Database\Seeder;

class StudentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StudentCategory::class, 5)->create();
    }
}
