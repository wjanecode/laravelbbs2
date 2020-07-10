<?php

namespace App\Models;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function user(  ) {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category(  ) {
        return $this->belongsTo(Category::class,'category_id');
    }

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

    public function scopeRecentReply( $query ) {
        //最新回复,有回复时更新reply_count字段,所以会更新
        return $query->orderBy('updated_at','desc');
    }


}
