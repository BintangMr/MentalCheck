<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionCategoryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_category_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_category_id');
            $table->foreign('question_category_id')->references('id')->on('question_categories');
            $table->string('original_filename');
            $table->string('modified_filename');
            $table->string('extension');
            $table->float('size');
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
        Schema::dropIfExists('question_category_images');
    }
}
