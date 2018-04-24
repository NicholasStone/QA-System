<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-23
 * Time: 下午3:07
 */

namespace App\Transformers;

use App\Models\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    public function transform(Image $image)
    {
        return [
            'id' => $image->id,
            'user' => $image->user_id,
            'type' => $image->type,
            'path' => $image->path,
            'created' => $image->created_at->toDateTimeString(),
            'updated' => $image->updated_at->toDateTimeString(),
        ];
    }
}