<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function before($user, $ability ) {
        //before方法会在其他策略之前运行
        //拥有管理内容的权限
        //直接返回true,后面的策略不再判断,
        //返回false直接拒绝所有策略,
        //返回null根据后面策略判断
        if ($user->can('manage_contents')){
            return true;
        }
    }

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
