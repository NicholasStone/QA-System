<?php

use App\Models\User;
use Faker\Generator as Faker;
use App\Models\QuestionTag;

$tags  = QuestionTag::all();
$users = (new User)->select(['id', 'verification'])->where('verification', '=', 1)->get();
$factory->define(\App\Models\Question::class, function (Faker $faker) use ($tags, $users) {
    $tag = $tags->random();
    if (isset($tag->meta['options'])) {
        $options = $tag->meta['options'];
    } else {
        $options = mt_rand(3, 7);
    }
    return [
        'tag_id'   => $tag->id,
        'user_id'  => $users->random()->id,
        'question' => $faker->text,
        'options'  => function () use ($tag, $faker, $options) {
            if (!$tag->type) return null;
            $result = [];
            for ($i = 1; $i <= $options; $i++) {
                $result[] = $faker->sentence();
            }
            return $result;
        },
        'answer'   => function (array $question) use ($tag, $faker, $options) {
            $result = null;
            if (empty($question['options'])) {
                $result = $faker->paragraphs;
            } else {
                if ($tag->meta['multiple']) {
                    $result = array_rand($question['options'], mt_rand(1, $options));
                } else {
                    $result = mt_rand(1, $options);
                }
            }
            return $result;
        },
    ];
});
