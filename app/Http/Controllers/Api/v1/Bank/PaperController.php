<?php

namespace App\Http\Controllers\Api\v1\Bank;

use Carbon\Carbon;
use App\Models\Paper;
use App\Http\Requests\Api\PageRequest;
use App\Http\Requests\Api\AttachRequest;
use App\Http\Controllers\Api\v1\Controller;
use App\Transformers\PaperTransformer;
use App\Http\Requests\Api\PaperRequest;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaperController extends Controller
{
    protected $paper;

    public function __construct(Paper $paper)
    {
        $this->paper = $paper;
    }

    /**
     * @param PageRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(PageRequest $request)
    {
        $paper = $this->paper->with([
            'user' => function (BelongsTo $user) {
                $user->select(['id', 'name', 'avatar', 'email']);
            }
        ])->paginate($request->input('per_page'));

        return $this->response->paginator($paper, new PaperTransformer());
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $paper = $this->paper
            ->with(['questions' => function (BelongsToMany $questions) {
                $questions->orderBy('pivot_sequence');
            }])
            ->whereId($id)
            ->firstOrFail();
        return $this->response->item($paper, new PaperTransformer());
    }

    /**
     * @param PaperRequest $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(PaperRequest $request)
    {
        return $this->paper->fill([
            'user_id'    => $this->user()->id,
            'title'      => $request->input('title'),
            'time_limit' => $request->input('time_limit') ?: null,
            'start_at'   => $request->has('start_at') ? Carbon::parse($request->input('start_at')) : null,
            'expire_at'  => $request->has('expire_at') ? Carbon::parse($request->input('expire_at')) : null,
        ])->save() ?
            $this->response->created(null, ['id' => $this->paper->id]) :
            $this->response->errorInternal("创建试卷时发生错误");
    }

    /**
     * @param PaperRequest $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PaperRequest $request, $id)
    {
        $paper = $this->paper->whereId($id)->firstOrFail();

        $this->authorize('update', $paper);

        return $paper->update($request->only(['title', 'time_limit', 'start_at', 'expire_at'])) ?
            $this->response->item($paper, new PaperTransformer()) :
            $this->response->errorInternal("修改试卷时发生错误");
    }

    /**
     * @param AttachRequest $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function attach(AttachRequest $request, $id)
    {

        $paper = $this->paper->whereId($id)->firstOrFail();

        $sync = $this->syncAdapter($request->input('questions'));

        $this->authorize('update', $paper);

        $paper->questions()->sync($sync);

        return $this->response->created(null, ['id' => $paper->questions->pluck('id')]);
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $paper = $this->paper->whereId($id)->firstOrFail();

        $this->authorize('delete', $paper);
        // detach all questions
        $paper->questions()->detach();

        // delete
        return $this->paper->whereId($id)->delete() ?
            $this->response->noContent() :
            $this->response->errorInternal('删除时发生错误');
    }

    protected function syncAdapter(Array $questions)
    {
        $result = [];
        foreach ($questions as $question) {
            $result[$question['id']] = ['score' => $question['score'], 'sequence' => $question['sequence']];
        }

        return $result;
    }
}
