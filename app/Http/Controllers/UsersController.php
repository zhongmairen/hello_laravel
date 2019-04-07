<?php
// 用户控制器
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

#用户控制器UsersController
class UsersController extends Controller
{
    //Auth 中间件，用户登录访问权限与策略控制器，排除以下动作，其它都不能操作
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index','confirmEmail']
        ]);
    }

    //index 动作来允许游客访问
    public function index()
    {
        //$users = User::all();未分页，全部显示
        $users = User::paginate(10);//分页显示
        return view('users.index', compact('users'));
    }



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
        #让用户注册成功后自动发送验证邮件
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');//注册成功后重定向到首页
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


    public function destroy(User $user)
    {
        // 删除授权策略 destroy 我们已经在上面创建了，这里我们在用户控制器中使用 authorize 方法来对删除操作进行授权验证即可。在删除动作的授权中，我们规定只有当前用户为管理员，且被删除用户不是自己时，授权才能通过。
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册成为 【微能平台】 用户！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    //confirm_email 路由对应的控制器方法 confirmEmail
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }



}
