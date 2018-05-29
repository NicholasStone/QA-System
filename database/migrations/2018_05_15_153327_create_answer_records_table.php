<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_records', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('user_id');
            $table->uuid('record_id');
            $table->integer('paper_question_id');
            $table->integer('paper_id');
            $table->integer('question_id');
            $table->text('answer')->nullable();
            $table->boolean('correctness')->default(false);
            $table->integer('score')->default(0);
            $table->integer('sequence')->default(1);
            $table->text('meta')->nullable();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answer_records');
    }
}
