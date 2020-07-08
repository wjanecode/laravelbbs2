<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(  ) {
        //未登录用户只能访问show方法
        $this->middleware('auth',['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create_and_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        //检查是否已授权,当前用户已自动传参进去,非本人不能编辑
        $this->authorize('update',$user);
        return view('users.create_and_edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        //
        $user = User::find($id);
        //检查是否已授权,当前用户已自动传参进去,非本人不能编辑
        $this->authorize('update',$user);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->introduction = $request->get('introduction');

        //判断有没有新设密码
        if ($password = $request->get('password')){
            $password = Hash::make($password);
            $user->password = $password;
        }

        //判断有没有头像文件,对上传的头像进行保存
        if ($avatar = $request->file('avatar')){
            //对图片进行处理
            $uploader = new ImageUploadHandler();
            $avatar = $uploader->upload($avatar,'avatars','avatar',1000);
            //赋值
            $user->avatar = $avatar['path'];
        }

        $user->save();

        session()->flash('success','信息保存成功');

        return view('users.show',compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //

    }
}
