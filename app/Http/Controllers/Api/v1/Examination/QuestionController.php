<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Controller;

class QuestionController extends Controller
{
    protected $question = null;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    public function index($slug = null)
    {
        $questions = $this->question->with('tag')->where('tag.slug', '=', $slug)->all();
        return $this->response->collection($questions, new QuestionTransformer());
    }
}
