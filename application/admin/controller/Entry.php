<?php

namespace app\admin\controller;

use app\admin\validate\Admin;
use think\Controller;

class Entry extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function pass()
    {

        if(request()->isPost())
        {
            $res = (new \app\common\model\Admin())->pass(input('post.'));
            if($res['valid'])
            {
                //清楚seesion中的登录信息
                session(null);
                //执行成功
                $this->success($res['msg'],'admin/entry/index');exit;
            } else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }
}
