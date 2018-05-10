<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Models\Examination;
use App\Http\Requests\Api\PageRequest;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExaminationController extends Controller
{
    protected $examination;

    public function __construct(Examination $examination)
    {
        $this->examination = $examination;
    }

    /**
     * @param PageRequest $request
     */
    public function index(PageRequest $request)
    {
        $page = null;
        $examination = $this->examination->with(function (BelongsTo $user) {
            $user->select(['id', 'name', 'avatar', 'email']);
        })->select(['']);

        if ($request->has('page')) {
            $page = $request->only(['page', 'pre_page']);
        }
    }

}
