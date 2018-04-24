<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path', 'type', 'user_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
