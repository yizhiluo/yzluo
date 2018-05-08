<?php

namespace app\admin\controller;

use app\common\model\Admin;
use houdunwang\crypt\Crypt;
use think\Controller;

class Login extends Controller
{
    public function login()
    {
        //       echo Crypt::decrypt('h3vPU8JGuF3VS/uxIpjRSw=='); //h3vPU8JGuF3VS/uxIpjRSw==

        //        echo Crypt::encrypt('admin888'); //h3vPU8JGuF3VS/uxIpjRSw==
        //加载登录页面
        //$data = db('admin')->find(1);
        if(request()->isPost())
        {
            $res = (new Admin())->login(input('post.'));
            if($res['valid'])
            {
                //说明登录成功
                $this->success($res['msg'],'admin/Entry/index');exit;
            } else{
               // 说明登录失败
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }
}
