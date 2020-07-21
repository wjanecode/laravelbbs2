<?php

namespace App\Models;

use App\Models\Traits\ActiveUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $avatar
 * @property string|null $introduction
 * @property int $notification_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read int|null $replies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail,JWTSubject
{
    use Notifiable,\Illuminate\Auth\MustVerifyEmail;
    use HasRoles;
    use ActiveUserTrait;
    use HasApiTokens;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction','phone','email_verified_at',
        'weixin_openid','weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token','password','weixin_openid','weixin_unionid'
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

       //网图,直接返回
        if( strchr($value,'http')){
            return $this->attributes['avatar'] = $value;
        }
        //非网图,如果没有upload/images/avatars路径的就是管理员后台上传的,只保存的basename
        if( ! strchr($value,'upload')){
            //补全地址
            $value = '/upload/images/avatars/'.$value;
        }
        return $this->attributes['avatar'] = $value;
    }

    /**
     * passport ,短信验证码登录,使用明文密码返回token
     * 查看源码, 在laravel\passport\src\Bridge\UserRepository.php
     * 添加该方法,明文密码和加密前的密码都通过
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function validateForPassportPasswordGrant( $username, $password ) {

        //直接使用数据库的明文 或者 加密后的hash值比较
        return $password == $this->password || Hash::check($password,$this->password);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        // TODO: Implement getJWTIdentifier() method.
        //返回主键id
        return $this->getKey();
    }

    /**
     * 需要额外在 JWT 载荷中增加的自定义内容
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }

    //未读通知+1
    public function plusNotifications(  ) {
        $this->increment('notification_count');
        $this->save();
    }

    //全部未读消息清零
    public function markAsRead(  ) {
        //统计数清零
        $this->notification_count = 0;
        $this->save();
        //标记关联的通知为read
        $this->unreadNotifications->markAsRead();
    }




}
