<?php

namespace App\Models;

use App\Models\Pivots\PaperQuestion;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $tag_id
 * @property int $user_id
 * @property string $question
 * @property string $answer
 * @property string|null $options
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Paper[] $examination
 * @property-read \App\Models\QuestionTag $tag
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUserId($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    protected $fillable = ['tag_id', 'user_id', 'question', 'answer', 'options'];

    public function examination()
    {
        return $this->belongsToMany(Paper::class)
                    ->as(PaperQuestion::class)
                    ->withPivot(['score', 'sequence'])
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo(QuestionTag::class);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize($value);
    }

    public function getOptionsAttribute($value)
    {
        return unserialize($value);
    }

    public function setAnswerAttribute($value)
    {
        $this->attributes['answer'] = serialize($value);
    }

    public function getAnswerAttribute($value)
    {
        return unserialize($value);
    }
}
