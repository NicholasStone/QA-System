<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Http\Requests\Api\AttachRequest;
use App\Models\Examination;
use App\Http\Requests\Api\PageRequest;
use App\Http\Controllers\Api\v1\Controller;
use App\Transformers\BlankTransformer;
use App\Transformers\ExaminationTransformer;
use App\Http\Requests\Api\ExaminationRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class ExaminationController extends Controller
{
    protected $examination;

    public function __construct(Examination $examination)
    {
        $this->examination = $examination;
    }

    /**
     * @param PageRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(PageRequest $request)
    {
        $examination = $this->examination->with([
            'user' => function (BelongsTo $user) {
                $user->select(['id', 'name', 'avatar', 'email']);
            }
        ])->paginate($request->input('per_page'));

        return $this->response->paginator($examination, new ExaminationTransformer());
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        return $this->response->item($this->examination->find($id), new ExaminationTransformer());
    }

    /**
     * @param ExaminationRequest $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(ExaminationRequest $request)
    {
        $examination = $request->only(['title', 'time_limit', 'start_at', 'expire_at']);

        return $this->examination->fill([
            'user_id'    => $this->user()->id,
            'title'      => $examination['title'],
            'time_limit' => $examination['time_limit'],
            'start_at'   => Carbon::parse($examination['start_at']),
            'expire_at'  => Carbon::parse($examination['expire_at']),
        ])->save() ?
            $this->response->created(null, ['id' => $this->examination->id]) :
            $this->response->errorInternal("创建试卷时发生错误");
    }

    /**
     * @param ExaminationRequest $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ExaminationRequest $request, $id)
    {
        $examination = $this->examination->whereId($id)->firstOrFail();

        $this->authorize('update', $examination);

        return $examination->update($request->only(['title', 'time_limit', 'start_at', 'expire_at'])) ?
            $this->response->item($examination, new ExaminationTransformer()) :
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
        $examination = $this->examination->whereId($id)->firstOrFail();

        $sync = $this->syncAdapter($request->input('questions'));

        $this->authorize('update', $examination);

        $examination->questions()->sync($sync);

        return $this->response->created(null, ['id' => $examination->questions->pluck('id')]);
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $examination = $this->examination->whereId($id)->firstOrFail();

        $this->authorize('delete', $examination);
        // detach all questions
        $examination->questions()->detach();

        // delete
        return $this->examination->whereId($id)->delete() ?
            $this->response->noContent() :
            $this->response->errorInternal('删除时发生错误');
    }

    protected function syncAdapter(Array $questions)
    {
        $result = [];
        foreach ($questions as $question) {
            $result[$question['id']] = ['score' => $question['score']];
        }

        return $result;
    }
}
