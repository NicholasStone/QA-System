<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-23
 * Time: 下午3:19
 */

namespace App\Handler;

use Illuminate\Http\UploadedFile;

class ImageUploadHandler
{
    protected $allowed_mimeType = ['image/gif', 'image/png', 'image/jpeg', 'image/bmp',];
    protected $extensions = [
        'image/gif' => 'git',
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
        'image/bmp' => 'bmp',
    ];

    public function save(UploadedFile $file, $folder, $file_prefix)
    {
        $folder_name = 'uploads/images/' . $folder . date('Y-m/d', time());

        $upload_path = public_path() . '/' . $folder_name;

        $extension = $this->extensions[$file->getMimeType()];

        $filename = $file_prefix . "-" . time() . "-" . str_random(10) . $extension;

        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename",
        ];
    }
}