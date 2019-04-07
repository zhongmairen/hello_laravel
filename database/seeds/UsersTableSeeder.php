<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用该方法来创建 50 个假用户
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'Joyefly';
        $user->email = 'Joyefly@example.com';
        $user->is_admin = true;//设置第一个用户为主管理员，密码为默认密码
        $user->save();
    }
}
