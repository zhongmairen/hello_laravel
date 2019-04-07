<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //些需要用户登录之后才能执行的请求，要借助 Auth 中间件来为这store 和 destroy 动作添加过滤请求
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function store(Request $request)
    {
        //要对微博的内容进行限制
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        //获取到当前用户实例,对微博的内容进行赋值
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        //back 方法导向至上一次发出请求的页面
        return redirect()->back();
    }
}
