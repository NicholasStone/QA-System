<?php

namespace App\Http\Controllers\Api\v1\Record;

use App\Http\Controllers\Api\v1\Controller;
use App\Models\Pivots\AnswerRecord;

class AnswerRecordController extends Controller
{
    protected $record = null;

    public function __construct(AnswerRecord $record)
    {
        $this->record = $record;
    }

}
