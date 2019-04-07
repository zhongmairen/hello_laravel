<?php
//微博模型
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //在微博模型的 fillable 属性中允许更新微博的 content 字段
    protected $fillable = ['content'];
    //在微博模型中，指明一条微博属于一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
