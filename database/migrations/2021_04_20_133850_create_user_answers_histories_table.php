<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswersHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answer_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_answer_id');
            $table->foreign('user_answer_id')->references('id')->on('user_answers');
            $table->unsignedBigInteger('question_answer_id');
            $table->foreign('question_answer_id')->references('id')->on('question_answers');
            $table->string("answer");
            $table->integer("point");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user_answer_histories');
        Schema::enableForeignKeyConstraints();
    }
}
