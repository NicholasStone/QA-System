<?php

use Faker\Generator as Faker;

$questions = \App\Models\Question::all();
$user = (new App\Models\User)->select(['id', 'verification'])->where('verification', '=', '1')->get();
$questions = (new App\Models\Question)->select(['id'])->get();
$factory->define(\App\Models\Examination::class, function (Faker $faker) use ($user) {
    $start_at = now()->addDays(mt_rand(0,30));
    return [
        'user_id' => $user->random()->id,
        'title' => $faker->sentence,
        'time_limit' => mt_rand(0, 7) * 30,
        'start_at' => $start_at,
        'expire_at' => $start_at->addDays(mt_rand(0,30)),
    ];
});
