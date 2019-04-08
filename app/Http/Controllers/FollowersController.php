<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class FollowersController extends Controller
{
    //store 和 destroy 动作，分别用于处理「关注」和「取消关注」用户的请求
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('follow', $user);//对用户身份做了授权判断
        //利用 isFollowing 方法来判断当前用户是否已关注了要进行操作的用户
        if ( ! Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        $this->authorize('follow', $user);//对用户身份做了授权判断
        //利用 isFollowing 方法来判断当前用户是否已关注了要进行操作的用户
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
}
