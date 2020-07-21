<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    //获取用户所有权限
    public function index( Request $request ) {

        $user = auth('api')->user();

        $permissions = $user->getAllPermissions();

        return PermissionResource::collection($permissions);
    }


}
