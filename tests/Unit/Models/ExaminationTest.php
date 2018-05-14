<?php

namespace Tests\Unit\Models;

use App\Models\Examination;
use App\Models\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ExaminationTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExaminations()
    {
        $questions = (new Question)->pluck('id');
        factory(Examination::class, 100)
            ->create()
            ->each(function (Examination $examination) use ($questions) {
                $questions
                    ->random(mt_rand(4, 30))
                    ->each(function ($q) use ($examination) {
                        $examination->questions()->attach($q, ['score' => rand(1, 20)]);
                    });
            });

        $this->assertLessThanOrEqual(Examination::all()->random()->questions->count(), 1);
    }
}
