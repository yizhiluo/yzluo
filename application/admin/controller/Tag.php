<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Tag extends Common
{
    public function  index()
    {
//        $list = Db::name('user')->where('status',1)->paginate(10);
        $field = Db::name('tag')->paginate(2);
        $page = $field->render();
        $this->assign('field',$field);
        $this->assign('page',$page);
        return $this->fetch();
    }

    public function  store()
    {
        $tag_id = input('param.tag_id');

        if(request()->isPost())
        {
            $res = (new \app\common\model\Tag())->store(input('post.'));
            if($res['valid']) {
                $this->success($res['msg'],'index');exit;
            } else{
                $this->error($res['msg']);exit;
            }
        }

        if($tag_id)
        {
            //说明是编辑
            $oldData =  Db::name('tag')->find($tag_id);

        }else{
            //添加
            $oldData = ['tag_name'=>''];
        }
        $this->assign('oldData',$oldData);
        return $this->fetch();
    }

    public function del()
    {
         $tag_id = input('param.tag_id');
         if(\app\common\model\Tag::destroy($tag_id))
         {
             //成功提示
             $this->success('操作成功','index');exit;
         } else{
             $this->error('删除失败');exit;
         }
    }
}
