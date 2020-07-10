<?php

namespace App\Models;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function posts(  ) {
        return $this->hasMany(Post::class,'category_id');
    }
}
