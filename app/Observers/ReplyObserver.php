<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\PostReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function saved( Reply $reply ) {

        $author = $reply->post->user;
        //给文章作者发送回复通知
        //排除本人回复
        if( $reply->user_id != $author->id){
            $author->notify(new PostReplied($reply));
        }

        //更新帖子时间
        $post = $reply->post;
        $post->updated_at = now();
        $post->save();

    }
}
