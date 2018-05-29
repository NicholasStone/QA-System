<?php

namespace App\Http\Controllers\Api\v1\Record;

use App\Http\Requests\Api\PageRequest;
use App\Models\Question;
use App\Models\Pivots\AnswerRecord;
use App\Models\Pivots\ExaminationRecord;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Api\AnswerRecordRequest;

class AnswerRecordController extends Controller
{
    protected $record = null;

    public function __construct(AnswerRecord $record)
    {
        $this->record = $record;
    }

    public function index(PageRequest $request)
    {
    }

    public function show($id)
    {

    }

    public function store(AnswerRecordRequest $request)
    {
        $record_id = $request->input('record');
        // 是否已提交过答案
        if (AnswerRecord::whereRecordId($record_id)->count() > 0) {
            return $this->response->errorForbidden('已提交过答案');
        }

        $examination_record = (new ExaminationRecord)->whereId($request->input('record'))->first();

        if (now()->gt($examination_record->finished_at)) {
            // 该考试是否已经结束
            return $this->response->errorForbidden('考试已结束');
        }

        $questions = $examination_record->paper->questions;

        list($total_score, $full_score) = $this->judgment($request->input('answers'), $questions, $examination_record);

        $examination_record->update([
            'total_score' => $total_score,
            'finished_at' => now(),
            'meta'        => [
                'full_score' => $full_score,
            ]
        ]);

        return $this->response->created(null, ['finished' => now()->toDateTimeString()]);
    }

    protected function judgment(Array $answers, Collection $correct, ExaminationRecord $record)
    {
        $total_score = 0;
        $full_score  = 0;
        $result      = $correct->map(function (Question $question, $key) use ($answers, $record, &$total_score, &$full_score) {
            $tag    = $question->tag;
            $result = [
                'user_id'           => $this->user()->id,
                'record_id'         => $record->id,
                'paper_question_id' => $question->getOriginal('pivot_id'),
                'paper_id'          => $record->paper->id,
                'question_id'       => $question->id,
                'answer'            => $answers[$key],
                'sequence'          => $question->getOriginal('pivot_sequence'),
                'correctness'       => false,
                'score'             => 0,
                'meta'              => [
                    'origin_answer'   => $question->answer,
                    'origin_score'    => $question->getOriginal('pivot_score'),
                    'origin_type'     => $tag->type,
                ],
            ];

            // 可判断的为客观题
            // 若客观题得到文字答案，则判断为错误
            if ($tag->type && !is_string($answers[$key])) {
                // 记录满分
                $full_score += $question->getOriginal('pivot_score');

                // 若答案类型不同，记零分
                if (gettype($answers[$key]) === gettype($question->answer)) {
                    // 若提交答案为数组， 则该答案与正确答案的差集中元素个数为 0 则正确
                    // 若提交答案不为数组，则该答案与正确答案相同则为正确
                    $result['correctness'] = is_array($answers[$key])
                        ? count(array_diff($question->answer, $answers[$key])) === 0
                        : $answers[$key] === $question->answer;
                    if ($result['correctness']){
                        $result['score'] = $question->getOriginal('pivot_score');
                        $total_score     += $result['score'];
                    }
                }

            }
            $model = AnswerRecord::create($result);
            return $model;
        });

        return [$total_score, $full_score];
    }
}
