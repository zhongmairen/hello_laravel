<?php

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
}
