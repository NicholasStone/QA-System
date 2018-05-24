<?php

namespace App\Models\Pivots;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExaminationRecord extends Pivot
{
    protected $table = 'examination_record';

    protected $fillable = ['paper_id', 'user_id', 'total_score', 'meta'];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMetaAttribute($value)
    {
        return unserialize($value);
    }

    public function setMetaAttribute($value)
    {
        return $this->attributes['meta'] = serialize($value);
    }
}
