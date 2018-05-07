<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-5
 * Time: 下午11:22
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    public function transform($question)
    {
        $data = [
            'id'     => $question->id,
            'user'   => [
                'id'     => $question->id,
                'name'   => $question->name,
                'avatar' => $question->avatar,
                'email'  => $question->email,
            ],
            'tag'    => [
                'id'    => $question->tag->id,
                'title' => $question->tag->name,
                'slug'  => $question->tag->slug,
                'type'  => $question->tag->type ? "客观题" : "主观题",
            ],
            'title'  => $question->question,
            'answer' => $question->answer,
        ];

        if ($question->tag->type) {
            $data['options'] = $question->options;
        }

        return $data;
    }
}