<?php
#主页控制器
#namespace代表的是 命名空间,区分归类不同的代码功能，避免引起变量名或函数名的冲突。你可以把命名空间理解为文件路径，把变量名理解为文件。当我们在不同路径分别存放了相同的文件时，系统就不会出现冲突。
namespace App\Http\Controllers;
#用 use 来引用在 PHP 文件中要使用的类，引用之后便可以对其进行调用。
use Illuminate\Http\Request;
use Auth;
#这个类继承了父类 App\Http\Controllers\Controller，任意使用父类中除私密方法外的其它方法。
class StaticPagesController extends Controller
{
    //主页对应的控制器动作home
    public function home()
    {

        //定义了一个空数组 feed_items 来保存微博动态数据
        $feed_items = [];
        //使用 Auth::check() 来检查用户是否已登录
        if (Auth::check()) {
            //获取用户的微博动态
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages/help');
    }
    public function about()
    {
        return view('static_pages/about');
    }
}
