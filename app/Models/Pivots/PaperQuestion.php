<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-12
 * Time: 下午10:35
 */

namespace App\Models\Pivots;

use App\Models\Paper;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PaperQuestion extends Pivot
{
    protected $fillable = ['paper_id', 'question_id', 'score', 'sequence'];
    protected $hidden = ['paper_id', 'question_id'];

    protected $table = 'paper_question';

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }
}