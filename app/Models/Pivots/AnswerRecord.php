<?php

namespace App\Models\Pivots;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnswerRecord extends Pivot
{
    protected $table = 'answer_records';

    protected $fillable = ['user_id', 'record_id', 'paper_question_id', 'answer', 'correctness', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examination_record()
    {
        return $this->belongsTo(ExaminationRecord::class, 'record_id');
    }

    public function paper_question()
    {
        return $this->belongsTo(PaperQuestion::class, 'paper_question_id');
    }


}
