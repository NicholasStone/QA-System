<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-24
 * Time: 下午5:29
 */

namespace App\Transformers;


use Illuminate\Queue\Jobs\Job;
use League\Fractal\TransformerAbstract;

class JobTransformer extends TransformerAbstract
{
    public function transform(Job $job)
    {
        return $job;
    }
}