<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
#用户控制器UsersController
class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
    #处理用户创建的相关逻辑,数据进行 validator()验证,第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        #store 方法接受一个 Illuminate\Http\Request 实例参数，我们可以使用该参数来获得用户的所有输入数据。如果我们的表单中包含一个 name 字段，则可以借助 Request 使用下面的这种方式来获取 name值
        #将注册表单提交绑定路由到存储数据库
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');#session()用户注册成功后，在页面顶部位置显示注册成功的提示信息
        return redirect()->route('users.show', [$user]);
    }

}
