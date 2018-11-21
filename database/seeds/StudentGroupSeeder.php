<?php

use Illuminate\Database\Seeder;

class StudentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StudentGroup::class, 5)->create();
    }
}
