<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    //站长直接返回true,后面的策略不再判断,
        //返回false直接拒绝所有策略,
        //返回null根据后面策略判断
	     if ($user->hasRole('master')) {
	     		return true;
	     }

	}
}
