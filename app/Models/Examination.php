<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Examination
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $time_limit
 * @property string $start_at
 * @property string|null $expire_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
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
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'examination_question');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
