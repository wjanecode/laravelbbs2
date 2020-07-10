<?php

namespace App\Models;

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
}
