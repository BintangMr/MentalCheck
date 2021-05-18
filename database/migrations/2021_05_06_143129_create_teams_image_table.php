<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teams_id');
            $table->foreign('teams_id')->references('id')->on('teams');
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
        Schema::dropIfExists('teams_image');
    }
}
