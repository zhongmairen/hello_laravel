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
        return;
    }

}
