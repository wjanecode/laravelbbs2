<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //要求用户已登录
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            //用户名:必须|长度3到25|唯一(排除当前登录的,不然没法修改自己的信息)
            'name'  =>  'required|between:3,25|unique:users,name,' . Auth::id(),
            //邮箱
            'email' =>  'required|email|unique:users,email,' . Auth::id(),
            //简介
            'introduction'  =>  'max:80',
        ];
    }

    public function messages(  ) {
        return [
            'name.required' =>  '用户名不能为空,长度3到25',
            'name.between'  =>  '用户名长度只能3到25之间',
            'name.unique'   =>  '用户名已存在,请换一个',

            'email.required'  =>  '邮箱不能为空',
            'email.unique'  =>  '邮箱已存在',
            'email.email'   =>  '邮箱格式不正确',

            'introduction.max'  =>  '简介不能超80个字'
        ];
    }
}
