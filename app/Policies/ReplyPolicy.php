<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        return $user->hasModles($reply);

    }

    public function destroy(User $user, Reply $reply)
    {
        //回复者或者文章所有者可以删除
        return $user->hasModles($reply) || $user->hasModles($reply->post);
    }
}
