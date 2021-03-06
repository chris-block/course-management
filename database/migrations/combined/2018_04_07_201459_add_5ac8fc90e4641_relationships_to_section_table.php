<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5ac8fc90e4641RelationshipsToSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sections', function(Blueprint $table) {
            if (!Schema::hasColumn('sections', 'course_id')) {
                $table->integer('course_id')->unsigned()->nullable();
                $table->foreign('course_id', '141618_5ac8fc3f45c63')->references('id')->on('courses')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function(Blueprint $table) {
            if(Schema::hasColumn('sections', 'course_id')) {
                $table->dropForeign('141618_5ac8fc3f45c63');
                $table->dropIndex('141618_5ac8fc3f45c63');
                $table->dropColumn('course_id');
            }
            
        });
    }
}
