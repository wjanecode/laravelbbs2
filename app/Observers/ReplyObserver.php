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
        $author->notify(new PostReplied($reply));



    }
}
