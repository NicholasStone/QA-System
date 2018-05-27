<?php

use App\Models\Paper;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PaperQuestionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->syncPaperWithQuestions(
            $this->allOrNew(Paper::class, 200),
            $this->allOrNew(Question::class, 5000)
        );
    }

    public function allOrNew($model, $n = 2000)
    {
        $items = app($model)->get();

        if (!$items->count()) {
            $items = factory($model, $n)->create();
        }

        return $items;
    }

    protected function syncPaperWithQuestions(Collection $papers, Collection $questions)
    {
        $papers->each(function (Paper $paper) use ($questions) {
            $questions
                ->random(mt_rand(4, 30))
                ->each(function ($q, $index) use ($paper) {
                    $paper->questions()->attach($q, ['score' => rand(1, 20), 'sequence' => $index + 1]);
                });
        });
    }
}
