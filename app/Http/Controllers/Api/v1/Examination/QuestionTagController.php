<?php

namespace App\Http\Controllers\Api\v1\Examination;

use App\Models\Question;
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
                ->where('status', '=', 1)
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
        $tag['meta'] = serialize(json_decode($tag['meta']));
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
     * @return \Dingo\Api\Http\Response
     */
    public function update(QuestionTagRequest $request)
    {
        $id = $request->input('id');
        $tag = $request->only(['name', 'slug', 'type', 'description', 'meta']);
        $tag = array_merge($tag, [
            'status' => 0
        ]);

        $this->tags->find($id)->update($tag);
        event(new QuestionTagEvent($this->tags));
        return $this->response->item($this->tags, new QuestionTagRequest())->statusCode(201);
    }
}
