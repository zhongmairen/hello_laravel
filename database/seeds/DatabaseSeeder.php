<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);调用 call 方法来指定我们要运行假数据填充的文件
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        //指定调用微博数据填充文件
        $this->call(StatusesTableSeeder::class);
        //指定用户关注关系列表填充文件
        $this->call(FollowersTableSeeder::class);

        Model::reguard();
    }
}
