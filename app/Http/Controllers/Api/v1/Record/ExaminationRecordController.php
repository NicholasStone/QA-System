<?php

namespace App\Http\Controllers\Api\v1\Record;

use App\Http\Requests\Api\FormRequest;
use App\Http\Controllers\Api\v1\Controller;
use App\Models\Pivots\ExaminationRecord;

class ExaminationRecordController extends Controller
{
    protected $record = null;

    public function __construct(ExaminationRecord $record)
    {
        return $this->record = $record;
    }

}
