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

    //定义微博动态控制器的 destroy 动作来处理微博的删除,『隐性路由模型绑定』功能，Laravel 会自动查找并注入对应 ID 的实例对象 $status，如果找不到就会抛出异常。
    public function destroy(Status $status)
    {
        //做删除授权的检测，不通过会抛出 403 异常。
        $this->authorize('destroy', $status);
        //调用 Eloquent 模型的 delete 方法对该微博进行删除。
        $status->delete();
        //删除成功之后，将返回到执行删除微博操作的页面上。
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
