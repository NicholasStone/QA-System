<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Http\Requests\Api\QuestionIndexRequest;
use App\Http\Requests\Api\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionTag;
use App\Transformers\QuestionTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    protected $question = null;
    protected $tag = null;

    public function __construct(Question $question, QuestionTag $tag)
    {
        $this->tag = $tag;
        $this->question = $question;
    }

    public function index(QuestionIndexRequest $request)
    {
        $slug = $request->input('slug');
        $page = $request->only(['per_page', 'page']);
//        $questions = $this->question->with([
//            'tag' => function (BelongsTo $tag) use ($slug) {
//                $condition = [['status', '=', '1']];
//                if (!empty($slug)) {
//                    array_push($condition, ['slug', '=', $slug]);
//                }
//                $tag
//                    ->select(['id', 'name', 'slug', 'type'])
//                    ->where($condition);
//            },
//            'user' => function (BelongsTo $user) {
//                $user->select(['id', 'name', 'avatar', 'email']);
//            }
//        ])
        $questions = $this->questionWithUserAndTag();

        if (!empty($slug)) {

            $tag = $this->tag->select(['id', 'slug'])->where([
                ['slug', '=', $slug], ['status', '>=', '1']
            ])->first();
            $questions->where('tag_id', '=', $tag->id);

        }
        $questions->limit(isset($page['per_page']) ? $page['per_page'] : 10)
            ->offset(isset($page['per_page']) ? $page['page'] * $page['per_page'] : 0);

        return $this->response->collection($questions->get(), new QuestionTransformer());
    }

    public function show($id)
    {
        $question = $this->questionWithUserAndTag()
            ->where('id', '=', $id)->first();

        return $this->response->item($question, new QuestionTransformer());
    }

    public function store(QuestionRequest $request)
    {
        $type = $request->input('type');
        $data = [
            'tag_id' => $request->input('tag'),
            'user_id' => $this->user()->id,
            'question' => $request->input('title'),
            'answer' => $request->input('answer'),
        ];
        if ($type) {
            $options = explode(',', $request->input('options'));
            $options = collect($options)->reject(function ($item) {
                return !is_integer($item);
            });
            $data['options'] = serialize($options);
        }
        dd($data);
        $this->question->fill($data)->save();

        return $this->response->created();
    }

    /**
     * @return Question|Builder
     */
    public function questionWithUserAndTag()
    {
        return $this->question->with([
            'tag' => function (BelongsTo $tag) {
                $tag->select(['id', 'name', 'slug', 'type']);
            },
            'user' => function (BelongsTo $user) {
                $user->select(['id', 'name', 'avatar', 'email']);
            }]);
    }

}
