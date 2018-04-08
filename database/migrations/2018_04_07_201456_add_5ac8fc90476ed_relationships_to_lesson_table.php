<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5ac8fc90476edRelationshipsToLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function(Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'course_id')) {
                $table->integer('course_id')->unsigned()->nullable();
                $table->foreign('course_id', '141604_5ac8ed7943951')->references('id')->on('courses')->onDelete('cascade');
                }
                if (!Schema::hasColumn('lessons', 'section_id')) {
                $table->integer('section_id')->unsigned()->nullable();
                $table->foreign('section_id', '141604_5ac8fc8c0c7b7')->references('id')->on('sections')->onDelete('cascade');
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
        Schema::table('lessons', function(Blueprint $table) {
            
        });
    }
}
