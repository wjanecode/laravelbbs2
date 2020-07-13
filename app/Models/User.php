<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,\Illuminate\Auth\MustVerifyEmail;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(  ) {
        return $this->hasMany(Post::class,'user_id');
    }

    public function replies(  ) {
        return $this->hasMany(Reply::class,'user_id');
    }

    public function hasModles(Model $model ) {
        return $this->id == $model->user_id;
    }

    //password属性修改器,保存password之前都会经过这里处理
    public function setPasswordAttribute( $value ) {

        //判断密码长度,如果长度不等于60,就是未加密的,需要加密了再入库
        if (strlen($value) != 60){
            $value = Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }

    //avatar属性修改器,保存avatar之前都会经过这里处理
    public function setAvatarAttribute( $value ) {

        //如果没有upload/images/avatars路径的就是管理员后台上传的,只保存的basename
        if( ! strchr($value,'upload')){
            //补全地址
            $value = '/upload/images/avatars/'.$value;
        }

        $this->attributes['avatar'] = $value;
    }

}
