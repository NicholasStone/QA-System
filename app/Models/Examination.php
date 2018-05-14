<?php

namespace App\Models;

use App\Models\Pivots\ExaminationQuestionPivot;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $time_limit
 * @property string $start_at
 * @property string|null $expire_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Question[] $questions
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Examination whereUserId($value)
 * @mixin \Eloquent
 */
class Examination extends Model
{
    protected $fillable = ['user_id', 'title', 'time_limit', 'start_at', 'expire_at'];

    public function questions()
    {
        return $this->belongsToMany(Question::class)
                    ->as(ExaminationQuestionPivot::class)
                    ->withPivot('score')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atom()
    {
        return $this->only(['created_at', 'updated_at']);
    }
}
