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
            $data['options'] = $this->optionsAdapter($question->options);
        }

        if ($question->getOriginal('pivot_score')){
            $data['score'] = $question->getOriginal('pivot_score');
        }

        if ($question->getOriginal('pivot_sequence')){
            $data['sequence'] = $question->getOriginal('pivot_sequence');
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

    protected function optionsAdapter($options)
    {
        // dd($options);
        $result = [];
        foreach ($options as $key => $item) {
            if(is_array($item)){
                foreach ($item as $index => $option) {
                    $result[] = compact('index', 'option');
                }
            } else {
                $result[] = ['index' => $key + 1, 'option' => $item];
            }
        }
        return $result;
    }
}