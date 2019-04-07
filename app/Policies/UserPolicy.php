<?php
// 用户授权策略类
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    //为默认生成的用户授权策略添加 update 方法，用于用户更新时的权限验证
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    //加上 destroy 删除用户动作相关的授权
    public function destroy(User $currentUser, User $user)
    {
        //我们使用了下面这行代码来指明，只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接。
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }


}
