<?php
#登录表单，会话控制器
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //guest 属性进行设置，只让未登录用户访问登录页面和注册页面
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    //登录代码
      public function store(Request $request)
    {
        #登录的简单验证
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

        #登录账密的数据库比对验证
       if (Auth::attempt($credentials,$request->has('remember'))) {
           if(Auth::user()->activated){
           // 登录成功后的相关操作
        session()->flash('success', '欢迎回来！');
        #redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
        $fallback = route('users.show', Auth::user());
        return redirect()->intended($fallback);
         } else {
            Auth::logout();
               session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
               return redirect('/');
           }
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
