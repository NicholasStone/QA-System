<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionTag
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property int $type
 * @property int $status
 * @property string|null $description
 * @property string|null $meta
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionTag whereUserId($value)
 * @mixin \Eloquent
 */
class QuestionTag extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'type', 'status', 'description', 'meta'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = serialize($value);
    }

    public function getMetaAttribute()
    {
        return empty($this->attributes['meta']) ? null : unserialize($this->attributes['meta']);
    }
}
