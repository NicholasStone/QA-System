<?php

namespace App\Http\Controllers\Api\v1\Bank;

use App\Models\Question;
use App\Models\QuestionTag;
use App\Http\Requests\Api\PageRequest;
use App\Transformers\QuestionTransformer;
use App\Http\Requests\Api\QuestionRequest;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionController extends Controller
{
    protected $question = null;
    protected $tag      = null;

    /**
     * QuestionController constructor.
     * @param Question $question
     * @param QuestionTag $tag
     */
    public function __construct(Question $question, QuestionTag $tag)
    {
        $this->tag      = $tag;
        $this->question = $question;
    }

    /**
     * @param PageRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(PageRequest $request)
    {
        $slug      = $request->input('slug');
        $questions = $this->questionWithUserAndTag();

        if (!empty($slug)) {
            $tag = $this->tag->select(['id', 'slug'])->where([
                ['slug', '=', $slug], ['status', '>=', '1']
            ])->first();
            $questions->where('tag_id', '=', $tag->id);
        }

        return $this->response->paginator(
            $questions->paginate($request->input('per_page')),
            new QuestionTransformer()
        );
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionWithUserAndTag()
                         ->where('id', '=', $id)->firstOrFail();

        return $this->response->item($question, new QuestionTransformer());
    }

    /**
     * @param QuestionRequest $request
     * @return \Dingo\Api\Http\Response|void
     */
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
            $data['options'] = collect($request->input('options'))->pluck('t');
        }

        return $this->question->fill($data)->save() ?
            $this->response->created(null, ['id' => $this->question->id]) :
            $this->response->errorInternal("创建问题时发生错误");
    }

    /**
     * @param QuestionRequest $request
     * @param int $id
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(QuestionRequest $request, int $id)
    {
        $question = $this->question->findOrFail($id);
        $data     = $request->only(['tag', 'question', 'answer', 'options']);
        if ($request->has('tag')) {
            $data['tag_id'] = $data['tag'];
            unset($data['tag']);
        }
        $this->authorize('update', $question);
        $question->update($data);
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
