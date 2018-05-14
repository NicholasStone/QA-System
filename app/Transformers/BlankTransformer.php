<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-5-11
 * Time: 下午7:07
 */

namespace App\Transformers;


use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;

class BlankTransformer extends TransformerAbstract
{
    /**
     * @param $value
     * @return array|null
     */
    public function  transform($value)
    {
        if (is_array($value)){
            return $value;
        } elseif ($value instanceof Collection){
            return $value->toArray();
        }

        return null;
    }
}