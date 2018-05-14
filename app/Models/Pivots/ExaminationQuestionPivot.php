<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-12
 * Time: 下午10:35
 */

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExaminationQuestionPivot extends Pivot
{
    protected $fillable = ['examination_id', 'question_id', 'score'];
    protected $hidden = ['examination_id', 'question_id'];

    protected $table = 'examination_question';
}