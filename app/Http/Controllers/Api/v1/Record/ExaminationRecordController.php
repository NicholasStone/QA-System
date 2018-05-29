<?php

namespace App\Http\Controllers\Api\v1\Record;

use Carbon\Carbon;
use App\Models\Paper;
use App\Http\Requests\Api\PageRequest;
use App\Models\Pivots\ExaminationRecord;
use App\Http\Controllers\Api\v1\Controller;
use App\Transformers\ExaminationRecodeTransformer;
use App\Http\Requests\Api\ExaminationRecordRequest;

class ExaminationRecordController extends Controller
{
    protected $record = null;

    /**
     * ExaminationRecordController constructor.
     * @param ExaminationRecord $record
     */
    public function __construct(ExaminationRecord $record)
    {
        return $this->record = $record;
    }

    public function index(PageRequest $request)
    {
        $records = $this->record->whereUserId($this->user()->id)->paginate($request->input('per_page'));

        return $this->response->paginator($records, new ExaminationRecodeTransformer());
    }

    public function show($id)
    {
        $record = $this->record->with(['answer_record' => function($query){
            $query->orderBy('sequence');
        }])->whereId($id)->firstOrFail();

        return $this->response->item($record, new ExaminationRecodeTransformer());
    }

    public function store(ExaminationRecordRequest $request)
    {
        $paper_id = $request->input('paper');

        $paper = (new Paper)->whereId($paper_id)->firstOrFail();

        $result = ExaminationRecord::create([
            'paper_id'    => $paper_id,
            'user_id'     => $request->user()->id,
            'started_at'  => now(),
            'finished_at' => now()->addMinutes($paper->time_limit),
        ]);

        return $this->response->created(null, [
            'id'      => $result->id,
            'started' => $result->started_at->toDateTimeString(),
            'finished' => $result->finished_at->toDateTimeString()
        ]);
    }

}
