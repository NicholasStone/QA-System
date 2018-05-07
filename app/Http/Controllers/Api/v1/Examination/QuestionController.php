<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Http\Requests\Api\QuestionIndexRequest;
use App\Http\Requests\Api\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionTag;
use App\Transformers\QuestionTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Controllers\Api\v1\Controller;

class QuestionController extends Controller
{
    protected $question = null;
    protected $tag = null;

    public function __construct(Question $question, QuestionTag $tag)
    {
        $this->tag      = $tag;
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
            'tag_id'   => $request->input('tag'),
            'user_id'  => $this->user()->id,
            'question' => $request->input('question'),
            'answer'   => explode(',', $request->input('answer')),
        ];

        if ($type) {
            $options         = json_decode($request->input('options'), true);
            $data['options'] = array_values($options);
        }

        $this->question->fill($data)->save();

        return $this->response->created();
    }

    public function update(QuestionRequest $request, int $id)
    {
        $question = $this->question->findOrFail($id);
        $data     = $request->only(['tag', 'question', 'answer', 'options']);
        if ($request->has('tag')) {
            $data['tag_id'] = $data['tag'];
            unset($data['tag']);
        }
        $question->update();
        return $this->response->item($question, new QuestionTransformer())->statusCode(201);
    }

    /**
     * @return Question|Builder
     */
    public function questionWithUserAndTag()
    {
        return $this->question->with([
            'tag'  => function (BelongsTo $tag) {
                $tag->select(['id', 'name', 'slug', 'type']);
            },
            'user' => function (BelongsTo $user) {
                $user->select(['id', 'name', 'avatar', 'email']);
            }]);
    }
}
