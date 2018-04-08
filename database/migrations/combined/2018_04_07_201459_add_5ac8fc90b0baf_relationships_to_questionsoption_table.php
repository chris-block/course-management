<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5ac8fc90b0bafRelationshipsToQuestionsOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions_options', function(Blueprint $table) {
            if (!Schema::hasColumn('questions_options', 'question_id')) {
                $table->integer('question_id')->unsigned()->nullable();
                $table->foreign('question_id', '141606_5ac8f1120973a')->references('id')->on('questions')->onDelete('cascade');
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
        Schema::table('questions_options', function(Blueprint $table) {
            if(Schema::hasColumn('questions_options', 'question_id')) {
                $table->dropForeign('141606_5ac8f1120973a');
                $table->dropIndex('141606_5ac8f1120973a');
                $table->dropColumn('question_id');
            }
            
        });
    }
}
