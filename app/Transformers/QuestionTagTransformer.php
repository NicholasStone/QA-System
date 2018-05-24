<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-5
 * Time: 下午3:39
 */

namespace App\Transformers;

use App\Models\QuestionTag;
use League\Fractal\TransformerAbstract;

class QuestionTagTransformer extends TransformerAbstract
{

    protected $availableIncludes=['atom', 'user'];

    public function transform(QuestionTag $tag)
    {
        return [
            'id' => $tag->id,
            'title' => $tag->name,
            'slug' => $tag->slug,
            'type' => $tag->type, //? '客观题' : '主观题',
            'meta' => $tag->meta,
            'description' => $tag->description,
            'status' => $tag->status,
            'created' => $tag->created_at->toDateString(),
            'updated' => $tag->updated_at->toDateString()
        ];
    }

    public function includeUser(QuestionTag $tag)
    {
        return $this->item($tag->user, new UserTransformers());
    }

}