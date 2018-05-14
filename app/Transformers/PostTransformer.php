<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-14
 * Time: 下午9:11
 */

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'category' => $post->category,
            'title' => $post->title,
            'seo' => $post->seo_title,
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->authorId, new UserTransformers());
    }
}
/*
int $id
int $author_id
int|null $category_id
string $title
string|null $seo_title
string|null $excerpt
string $body
string|null $image
string $slug
string|null $meta_description
string|null $meta_keywords
string $status
int $featured
 */