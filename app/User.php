<?php
#Laravel 默认为我们生成了用户模型文件
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    #Notifiable消息通知相关功能引用
    #Authenticatable授权相关功能的引用
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    #过滤用户提交的字段，只有包含在该属性中的字段才能够被正常更新：
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    #当我们需要对用户密码或其它敏感信息在用户实例通过数组或 JSON 显示时进行隐藏，则可使用 hidden 属性：
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
