<?php

namespace App\Models;

use App\Handlers\MarkdownHandler;

class Reply extends Model
{
    protected $fillable = ['post_id', 'user_id', 'content'];

    public function post(  ) {
        return $this->belongsTo(Post::class,'post_id');
    }

    public function user(  ) {
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeRecent($query  ) {
        return $query->orderBy('created_at','desc');
    }


    public function getContentAttribute($value  ) {
        $convert = new MarkdownHandler();
        $value = $convert->convertMarkdownToHtml($value);
        return $value;
    }
}
