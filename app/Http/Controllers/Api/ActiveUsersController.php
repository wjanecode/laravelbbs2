<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActiveUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ActiveUsersController extends Controller
{
    //
    public function index(User $user) {

        $active_users = $user->addActiveUser();

        return UserResource::collection($active_users);
    }
}
