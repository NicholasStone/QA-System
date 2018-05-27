<?php

namespace App\Models\Pivots;

use App\Models\Paper;
use App\Models\User;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExaminationRecord
 *
 * @package App\Models\Pivots
 * @property int $id
 * @property int $paper_id
 * @property int $user_id
 * @property int $total_score
 * @property string $meta
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $started_at
 * @property \Carbon\Carbon $finished_at
 * @property-read Paper $paper
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Paper whereId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|AnswerRecord[] $answer_record
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord wherePaperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExaminationRecord whereUserId($value)
 * @mixin \Eloquent
 */
class ExaminationRecord extends Model
{
    public $incrementing = false;

    protected $table = "examination_records";

    protected $keyType = 'string';

    protected $fillable = ['paper_id', 'user_id', 'total_score', 'meta', 'started_at'];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answer_record()
    {
        return $this->hasMany(AnswerRecord::class, 'record_id');
    }

    public function getMetaAttribute($value)
    {
        return unserialize($value);
    }

    public function setMetaAttribute($value)
    {
        return $this->attributes['meta'] = serialize($value);
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
