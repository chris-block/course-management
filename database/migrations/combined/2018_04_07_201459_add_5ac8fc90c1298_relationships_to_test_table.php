<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5ac8fc90c1298RelationshipsToTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function(Blueprint $table) {
            if (!Schema::hasColumn('tests', 'course_id')) {
                $table->integer('course_id')->unsigned()->nullable();
                $table->foreign('course_id', '141617_5ac8fade26ac9')->references('id')->on('courses')->onDelete('cascade');
                }
                if (!Schema::hasColumn('tests', 'lesson_id')) {
                $table->integer('lesson_id')->unsigned()->nullable();
                $table->foreign('lesson_id', '141617_5ac8fade3499c')->references('id')->on('lessons')->onDelete('cascade');
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
        Schema::table('tests', function(Blueprint $table) {
            if(Schema::hasColumn('tests', 'course_id')) {
                $table->dropForeign('141617_5ac8fade26ac9');
                $table->dropIndex('141617_5ac8fade26ac9');
                $table->dropColumn('course_id');
            }
            if(Schema::hasColumn('tests', 'lesson_id')) {
                $table->dropForeign('141617_5ac8fade3499c');
                $table->dropIndex('141617_5ac8fade3499c');
                $table->dropColumn('lesson_id');
            }
            
        });
    }
}
