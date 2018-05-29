<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\PageRequest;
use App\Models\Post;
use App\Transformers\PostTransformer;
use Dingo\Api\Http\Request;

class PostController extends Controller
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(PageRequest $request)
    {
        $posts = $this->post
            ->published()
            ->orderBy('created_at')
            ->paginate($request->input('per_page'));
        return $this->response->paginator($posts, new PostTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post $post
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id)
    {
        $post = $post->where('id', '=', $id)->published()->firstOrFail();
        return $this->response->item($post, new PostTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
