<?php

use Illuminate\Database\Seeder;

class QuestionTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('question_tags')->truncate();

        $this->findQuestionTag('single-choice-question')
            ->fill([
                'user_id' => 1,
                'name' => '单选题',
                'status' => 1,
                'slug' => 'single-choice-question',
                'meta' => [
                    'multiple' => false
                ],
                'description' => '所有选项中只有一个选项是正确的',
            ])->save();

        $this->findQuestionTag('multiple-choice-question')
            ->fill([
                'user_id' => 1,
                'name' => '多选题',
                'status' => 1,
                'slug' => 'multiple-choice-question',
                'meta' => [
                    'multiple' => true
                ],
                'description' => '所有选项中可能有多个是正确的',
            ])->save();

        $this->findQuestionTag('true-or-false')
            ->fill([
                'user_id' => 1,
                'name' => '判断题',
                'status' => 1,
                'slug' => 'true-or-false',
                'meta' => [
                    'multiple' => false,
                    'options' => 2
                ],
                'description' => '判断正误',
            ])->save();

        $this->findQuestionTag('brief-answer')
            ->fill([
                'user_id' => 1,
                'name' => '简答题',
                'status' => 1,
                'slug' => 'brief-answer',
                'type' => false,
                'description' => '简答'
            ])->save();
    }

    protected function findQuestionTag(string $slug)
    {
        return \App\Models\QuestionTag::firstOrNew(['slug' => $slug]);
    }
}
