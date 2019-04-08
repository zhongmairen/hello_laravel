<?php
//用户模型
#Laravel 使用artisan命令默认生成了用户模型文件,文件夹路径
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

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

    //feed动态流方法,将当前用户发布过的所有微博从数据库中取出，并根据创建时间来倒序排序,再加入关注人的微博动态数据
    public function feed()
    {
        //通过 followings 方法取出所有关注用户的信息，再借助 pluck 方法将 id 进行分离并赋值给 user_ids
        $user_ids = $this->followings->pluck('id')->toArray();
        //将当前用户的 id 加入到 user_ids 数组中
        array_push($user_ids, $this->id);
        //查询构造器 whereIn 方法取出所有用户的微博动态并进行倒序排序
        return Status::whereIn('user_id', $user_ids)
                              ->with('user')//预加载 with 方法，预加载避免了 N+1 查找的问题，大大提高了查询效率。
                              ->orderBy('created_at', 'desc');
    }

    //「多对多关系」粉丝关注模型
    //粉丝关系列表
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }
    //用户关注别人时用这个方法
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    //实现用户的「关注」和「取消关注」的相关逻辑，具体在用户模型中定义关注（follow）和取消关注（unfollow）的方法如下
    //「关注」
    public function follow($user_ids)
    {
        //is_array 用于判断参数是否为数组，如果已经是数组，则没有必要再使用 compact 方法
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        //sync方法会自动获取数组中的 id
        $this->followings()->sync($user_ids, false);
    }
    //「取消关注」
    public function unfollow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        //detach方法会自动获取数组中的 id
        $this->followings()->detach($user_ids);
    }

    //判断当前登录的用户 A 是否关注了用户 B，代码实现逻辑很简单，我们只需判断用户 B 是否包含在用户 A 的关注人列表上即可。这里我们将用到 contains 方法来做判断。
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
