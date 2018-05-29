<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableNameExaminationQuestionToPaperQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examination_question', function (Blueprint $table) {
            $table->addColumn('integer', 'sequence');
            $table->renameColumn('examination_id', 'paper_id');
            $table->rename('paper_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper_question', function (Blueprint $table) {
            $table->dropColumn('sequence');
            $table->renameColumn('paper_question', 'examination_id');
            $table->rename('examination_question');
        });
    }
}
