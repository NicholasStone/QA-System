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
    public function transform(QuestionTag $tag)
    {
        return [
            'id' => $tag->id,
            'user' => [
                'id' => $tag->user->id,
                'name' => $tag->user->name,
                'email' => $tag->user->email,
                'avatar' => $tag->user->avatar,
            ],
            'title' => $tag->name,
            'slug' => $tag->slug,
            'type' => $tag->type ? '客观题' : '主观题',
            'meta' => $tag->meta,
            'description' => $tag->description,
            'status' => function ($status) {
                switch ($status) {
                    case 1:
                        return "审核已通过";
                        break;
                    case 0:
                        return "正等待审核";
                        break;
                    case -1:
                        return "审核未通过，请修改或删除";
                        break;
                }
            }
        ];
    }
}