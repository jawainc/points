<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesColumnToPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('points', 'notes'))
        {
            Schema::table('points', function (Blueprint $table) {
                $table->addColumn('text', 'notes')->nullable();
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
        if(Schema::hasColumn('points', 'notes'))
        {
            Schema::table('points', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
}
