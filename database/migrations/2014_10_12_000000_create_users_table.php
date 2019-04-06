<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
#定义了一个 CreateUsersTable 类，并继承自 Migration 基类
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    #运行迁移时up
    public function up()
    {
        #调用 Schema 类的 create 方法来创建 users 表，create 方法会接收两个参数：一个是数据表的名称，另一个则是接收 $table（Blueprint 实例）的闭包；CreateUsersTable 类中通过 Blueprint 的实例 $table 为 users 表创建所需的数据库字段
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    #回滚迁移时的down方法。会回复到执行up方法前的状态。相当于删除了users表
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
