<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Models\QuestionTag;
use App\Events\QuestionTagEvent;
use App\Http\Requests\Api\QuestionTagRequest;
use App\Transformers\QuestionTagTransformer;
use App\Http\Controllers\Api\v1\Controller;

class QuestionTagController extends Controller
{
    protected $tags = null;

    public function __construct(QuestionTag $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response
            ->collection($this->tags
                ->whereStatus(1)
                ->get(), new QuestionTagTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionTagRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(QuestionTagRequest $request)
    {
        $tag = $request->only(['name', 'slug', 'type', 'description', 'meta']);
        $tag['meta'] = json_decode($tag['meta']);
        $tag = array_merge($tag, [
            'user_id' => $this->user()->id,
            'status' => 0
        ]);
        event(new QuestionTagEvent(QuestionTag::create($tag)));
        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return $this->response
            ->item($this->tags->where('slug', '=', $slug)->first(), new QuestionTagTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionTagRequest $request
     * @param int $id
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(QuestionTagRequest $request, int $id)
    {
        $data = $request->only(['name', 'slug', 'type', 'description', 'meta']);
        $data['states'] = 0;
        $data['meta'] = json_decode($data['meta']);

        $tag = $this->tags->findOrFail($id);
        $this->authorize('update', $tag);
        $tag->update($data);
        event(new QuestionTagEvent($tag));
        return $this->response->item($tag, new QuestionTagTransformer())->statusCode(201);
    }
}
