<?php

namespace App\Models;

use App\Handlers\MarkdownHandler;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property int $category_id
 * @property int $reply_count
 * @property int $view_count
 * @property int $last_reply_user_id
 * @property int $order
 * @property string|null $excerpt
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model recent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post recentPublish()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post recentReply()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereLastReplyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereReplyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withOrder($order)
 * @mixin \Eloquent
 */
class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function user(  ) {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category(  ) {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function replies(  ) {
        return $this->hasMany(Reply::class,'post_id');
    }

    //排序
    public function scopeWithOrder($query,$order) {

        //根据不同order来分配不同排序
        //调用时直接使用withOrder($order)
        switch ($order){
            //最新发布
            case 'recentPublish':
                $query->recentPublish();
                break;
            //默认使用最新回复,没有order时也时
            default:
                $query->recentReply();
                break;
        }
    }

    public function scopeRecentPublish( $query ) {
        //最新发布,created_at 降序
        return $query->orderBy('created_at','desc');

    }

    //最新回复,有回复时更新reply_count字段,所以会更新
    public function scopeRecentReply( $query ) {
        //最新回复,有回复时更新reply_count字段,所以会更新
        return $query->orderBy('updated_at','desc');
    }

    //属性访问器,转换 Markdown to HTML
    public function getBodyAttribute($value  ) {
        $convert = new MarkdownHandler();
        $value = $convert->convertMarkdownToHtml($value);
        return $value;
    }


}
