<?php
//微博授权策略,对用户进行授权删除的操作，只有当被删除的微博作者为当前用户，授权才能通过
namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
//引入用户模型和微博模型
use App\Models\User;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //添加 destroy 方法定义微博删除动作相关的授权
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
