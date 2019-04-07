<?php
// 用户控制器
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
        #让用户注册成功后自动登录系统
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');#session()用户注册成功后，在页面顶部位置显示注册成功的提示信息
        return redirect()->route('users.show', [$user]);
    }
    //将查找到的用户实例 $user 与编辑视图进行绑定
    public function edit(User $user)
    {
        //此 trait 提供了 authorize 方法，它可以被用于快速授权一个指定的行为，当无权限运行该行为时会抛出 HttpException。authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    //在用户控制器加上 update 动作来处理用户提交的个人信息
    public function update(User $user, Request $request)
    {
        //同上
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);//相当于$user->id
    }

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);
    }

}
