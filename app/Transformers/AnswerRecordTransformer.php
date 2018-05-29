<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-25
 * Time: 下午1:21
 */

namespace App\Transformers;


use App\Models\Pivots\AnswerRecord;
use League\Fractal\TransformerAbstract;

class AnswerRecordTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'examination', 'paper', 'question'];

    public function transform(AnswerRecord $record)
    {
        return [
            'id'          => $record->id,
            'answer'      => $record->answer,
            'correctness' => $record->correctness,
            'score'       => $record->score,
            'sequence'    => $record->sequence,
            'meta'        => $record->meta,
        ];
    }

    public function includeUser(AnswerRecord $record)
    {
        return $this->item($record->user, new UserTransformers());
    }

}