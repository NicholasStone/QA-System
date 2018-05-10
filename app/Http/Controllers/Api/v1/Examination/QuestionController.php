<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Http\Requests\Api\PageRequest;
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
        $page      = $request->only(['per_page', 'page']);
        $questions = $this->questionWithUserAndTag();

        if (!empty($slug)) {

            $tag = $this->tag->select(['id', 'slug'])->where([
                ['slug', '=', $slug], ['status', '>=', '1']
            ])->first();
            $questions->where('tag_id', '=', $tag->id);

        }
//        $questions->limit(isset($page['per_page']) ? $page['per_page'] : 10)
//            ->offset(isset($page['per_page']) ? $page['page'] * $page['per_page'] : 0);

        return $this->response->paginator(
            $questions->paginate(isset($page['per_page']) ? $page['per_page'] : 15),
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
            ->where('id', '=', $id)->first();

        return $this->response->item($question, new QuestionTransformer());
    }

    /**
     * @param QuestionRequest $request
     * @return \Dingo\Api\Http\Response
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
            $options         = json_decode($request->input('options'), true);
            $data['options'] = array_values($options);
        }

        $this->question->fill($data)->save();

        return $this->response->created();
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
        $this->authorize('updateQuestion', $question);
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
