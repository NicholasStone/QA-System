<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-5
 * Time: 下午11:22
 */

namespace App\Transformers;

use App\Models\Question;
use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'tag'];

    public function transform(Question $question)
    {
        $data = [
            'id'      => $question->id,
            'title'   => $question->question,
            'answer'  => $question->answer,
            'created' => $question->created_at->toDateTimeString(),
            'updated' => $question->updated_at->toDateTimeString(),
        ];

        if ($question->tag->type) {
            $data['options'] = $question->options;
        }

        if ($question->getOriginal('pivot_score')){
            $data['score'] = $question->getOriginal('pivot_score');
        }

        return $data;
    }

    public function includeUser(Question $question)
    {
        return $this->item($question->user, new UserTransformers());
    }

    public function includeTag(Question $question)
    {
        return $this->item($question->tag, new QuestionTagTransformer());
    }
}