<?php

namespace App\Models;

use App\Models\Pivots\PaperQuestion;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $meta
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereMeta($value)
 */
class Paper extends Model
{
    use Searchable;

    protected $fillable = ['user_id', 'title', 'time_limit', 'start_at', 'expire_at'];

    public function questions()
    {
        return $this->belongsToMany(Question::class)
                    ->as(PaperQuestion::class)
                    ->withPivot(['score', 'sequence', 'id'])
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

    public function toSearchableArray()
    {
        return [
            'paper_id'    => $this->id,
            'title' => $this->title,
        ];
    }
}
