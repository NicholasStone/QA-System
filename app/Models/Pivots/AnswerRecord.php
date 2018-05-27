<?php

namespace App\Models\Pivots;

use App\Models\Paper;
use App\Models\Question;
use App\Models\User;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AnswerRecord
 *
 * @package App\Models\Pivots
 * @property int $id
 * @property int $user_id
 * @property int $record_id
 * @property int $paper_question_id
 * @property string $answer
 * @property int $correctness
 * @property int $score
 * @property-read User $user
 * @property-read ExaminationRecord $examination_record
 * @property-read PaperQuestion $paper_question
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereId($value)
 * @property string $recode_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereCorrectness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord wherePaperQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerRecord whereUserId($value)
 * @mixin \Eloquent
 */
class AnswerRecord extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'answer_records';

    protected $fillable = ['user_id', 'record_id', 'paper_question_id', 'paper_id', 'question_id', 'answer', 'correctness', 'score', 'meta'];

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

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function setAnswerAttribute($value)
    {
        $this->attributes['answer'] = serialize($value);
    }

    public function getAnswerAttribute()
    {
        return unserialize($this->attributes['answer']);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = serialize($value);
    }

    public function getMetaAttribute()
    {
        return empty($this->attributes['meta']) ? null : unserialize($this->attributes['meta']);
    }

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string)Uuid::generate(4);
        });
    }
}

