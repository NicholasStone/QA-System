<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('type')->default(true); // true -> objective, false -> subjective
            $table->tinyInteger('status')->default(0); //0 未审核, 1已过审核, -1 驳回
            $table->string('description')->nullable();
            $table->text('meta')->nullable();
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
        Schema::dropIfExists('question_types');
    }
}
