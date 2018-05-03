<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionType
 *
 * @property int $id
 * @property int $user_id
 * @property string $template
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionType whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionType whereUserId($value)
 * @mixin \Eloquent
 */
class QuestionType extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
