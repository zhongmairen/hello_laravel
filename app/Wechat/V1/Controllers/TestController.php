<?php
    /**
     * TestController.php
     *
     * Created by PhpStorm.
     * author: liuml  <liumenglei0211@163.com>
     * DateTime: 2018/8/20  10:02
     */

    namespace App\WechatXiaowei\V1\Controllers;

    class TestController extends BaseController
    {
        public function index(){
            return [
                'code' => 1,
                'message' => '操作成功',
                'data' => 111
            ];
        }

    }