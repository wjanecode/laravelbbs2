<?php

namespace App\Models;

use App\Handlers\MarkdownHandler;

/**
 * App\Models\Reply
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply recent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereUserId($value)
 * @mixin \Eloquent
 */
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
