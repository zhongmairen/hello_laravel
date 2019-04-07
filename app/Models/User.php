<?php
//用户模型
#Laravel 使用artisan命令默认生成了用户模型文件,文件夹路径
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //creating 用于监听模型被创建之前的事件，created 用于监听模型被创建之后的事件
    public static function boot()
    {
        parent::boot();

        static::creating(function($user)
        {
            $user->activation_token = str_random(30);

        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    #在用户模型中定义一个 gravatar 方法，用来生成用户的头像
    #该方法主要做了以下几个操作：
    /*  为 gravatar 方法传递的参数 size 指定了默认值 100；
        通过 $this->attributes['email'] 获取到用户的邮箱；
        使用 trim 方法剔除邮箱的前后空白内容；
        用 strtolower 方法将邮箱转换为小写；
        将小写的邮箱使用 md5 方法进行转码；
        将转码后的邮箱与链接、尺寸拼接成完整的 URL 并返回；
    */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    //用户模型中，指明一个用户拥有多条微博
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
