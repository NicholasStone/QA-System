<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-11
 * Time: 下午8:18
 */

namespace App\Transformers;

use App\Models\Paper;
use League\Fractal\TransformerAbstract;

class PaperTransformer extends TransformerAbstract
{
    protected $availableIncludes=['user', 'questions'];

    public function transform(Paper $paper)
    {
        return [
            'id' => $paper->id,
            'title' => $paper->title,
            'time_limit' => $paper->time_limit,
            'start' => $paper->start_at,
            'expire' => $paper->expire_at,
            'created' => $paper->created_at->toDateTimeString(),
            'updated' => $paper->updated_at->toDateTimeString(),
        ];
    }

    public function includeQuestions(Paper  $paper)
    {
        return $this->collection($paper->questions, new QuestionTransformer());
    }

    public function includeUser(Paper $paper)
    {
        return $this->item($paper->user, new UserTransformers());
    }
}