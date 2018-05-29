<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-29
 * Time: 下午7:11
 */

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['author', 'body'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
//            'category' => $post->category,
            'title'=> $post->title,
            // 'body' => $post->body,
            'excerpt' => $post->excerpt,
            'image' => $post->image,
            'published' => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includeAuthor(Post $post)
    {
        return $this->item($post->author, new UserTransformers());
    }

    public function includeBody(Post $post)
    {
        return $this->item(['text'=>$post->body], new BlankTransformer());
    }
}