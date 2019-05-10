<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotaColumnToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('courses', 'quota'))
        {
            Schema::table('courses', function (Blueprint $table) {
                $table->addColumn('integer', 'quota')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('courses', 'quota'))
        {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('quota');
            });
        }
    }
}
