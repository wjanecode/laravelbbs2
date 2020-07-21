<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends ApiController
{
    //
    public function __construct(  ) {

    }

    /**
     * 展示用户信息给游客(不需要token验证)
     * @param User $user
     *
     * @return UserResource
     */
    public function show(User $user ) {

        return new UserResource($user);
    }

    /**
     * 展示自己的信息,需要token
     * @return UserResource
     */
    public function me() {

        $user = auth('api')->user();

        return (new UserResource($user))->showSensitiveFields();
    }

    public function update(UserRequest $request ) {
        $user = $request->user();

        $attributes = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }

        $user->update($attributes);

        return (new UserResource($user))->showSensitiveFields();

    }


}
