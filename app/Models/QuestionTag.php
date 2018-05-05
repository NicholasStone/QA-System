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
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereUserId($value)
 * @mixin \Eloquent
 */
class QuestionTag extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = serialize($value);
    }

    public function getMetaAttribute($value)
    {
        return unserialize($value);
    }
}
