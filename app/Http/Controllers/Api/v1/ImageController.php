<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\UserAvatarChanged;
use App\Handler\ImageUploadHandler;
use App\Http\Requests\Api\ImageRequest;
use App\Models\Image;
use App\Transformers\ImageTransformer;

class ImageController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $handler)
    {
        $user = $this->user();

        $result = $handler->save($request->file('image'), str_plural($request->input('type')), $user->id);

        event(new UserAvatarChanged($image = $this->create([
            'path' => $result['path'],
            'type' => $request->input('type'),
            'user_id' => $user->id,
        ]), $user));

        return $this->response->item($image, new ImageTransformer())->setStatusCode(201);
    }

    protected function create(Array $image)
    {
        return Image::create($image);
    }
}
