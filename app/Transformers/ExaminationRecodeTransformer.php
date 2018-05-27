<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-25
 * Time: 下午12:44
 */

namespace App\Transformers;


use App\Models\Pivots\ExaminationRecord;
use League\Fractal\TransformerAbstract;

class ExaminationRecodeTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'paper'];

    public function transform(ExaminationRecord $record)
    {
        return [
            'id' => $record->id,
            'total_score' => $record->total_score,
            'meta' => $record->meta,
            'started' => $record->started_at->toDateTimeString(),
            'finished' => $record->finished_at->toDateTimeString(),
            'created' => $record->created_at->toDateTimeString(),
        ];
    }

    public function includeUser(ExaminationRecord $record)
    {
        return $this->item($record->user, new UserTransformers());
    }

    public function includePaper(ExaminationRecord $record)
    {
        return $this->item($record->paper, new PaperTransformer());
    }
}