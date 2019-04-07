<?php
#登录表单，会话控制器
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

      public function store(Request $request)
    {

        #登录的简单验证
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

        #登录账密的数据库比对验证
       if (Auth::attempt($credentials,$request->has('remember'))) {
           // 登录成功后的相关操作
        session()->flash('success', '欢迎回来！');
        #Laravel 提供的 Auth::user() 方法来获取 当前登录用户 的信息，并将数据传送给路由。
        return redirect()->route('users.show', [Auth::user()]);
       } else {
                // 登录失败后的相关操作
        session()->flash('danger', '很抱歉，您的邮箱和密码不匹配，请重新输入！');
        #使用 withInput() 后模板里 old('email') 将能获取到上一次用户提交的内容，这样用户就无需再次输入邮箱等内容
        return redirect()->back()->withInput();
       }
    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
