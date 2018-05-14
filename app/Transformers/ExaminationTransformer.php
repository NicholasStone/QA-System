<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-11
 * Time: 下午8:18
 */

namespace App\Transformers;

use App\Models\Examination;
use League\Fractal\TransformerAbstract;

class ExaminationTransformer extends TransformerAbstract
{
    protected $availableIncludes=['user', 'questions'];

    public function transform(Examination $examination)
    {
        return [
            'id' => $examination->id,
            'title' => $examination->title,
            'time_limit' => $examination->time_limit,
            'start' => $examination->start_at,
            'expire' => $examination->expire_at,
            'created' => $examination->created_at->toDateTimeString(),
            'updated' => $examination->updated_at->toDateTimeString(),
        ];
    }

    public function includeQuestions(Examination  $examination)
    {
        return $this->collection($examination->questions, new QuestionTransformer());
    }

    public function includeUser(Examination $examination)
    {
        return $this->item($examination->user, new UserTransformers());
    }
}