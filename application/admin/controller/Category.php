<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Category extends Common
{


    protected function __initialize()
    {
        parent::initialize();

    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取栏目数据
//        $field = db('cate')->select();
        $field = (new \app\common\model\Category())->getAll();

        $this->assign('field',$field);
        return $this->fetch();
    }


    public function store()
    {
        if(request()->isPost())
        {
            //halt($_POST);
            $res = (new \app\common\model\Category())->store(input('post.'));
            if($res['valid'])
            {
                $this->success($res['msg'],'index');exit;
            } else{
                $this->error($res["msg"]);exit;
            }
        }

        return $this->fetch();

    }

    //添加子集
    public function addSon()
    {
        if(request()->isPost())
        {
            //halt($_POST);exit;
            $res = (new \app\common\model\Category())->store(input('post.'));
            if($res['valid'])
            {
                $this->success($res['msg'],'index');exit;
            } else{
                $this->error($res["msg"]);exit;
            }
        }
        $cate_id = input('param.cate_id');

        $data = Db::name('cate')->where('cate_id',$cate_id)->find();
        $this->assign('data',$data);
        return $this->fetch();

    }

    //编辑分类
    public function edit()
    {
//        halt($_POST);
        if(request()->isPost())
        {
            $res = (new \app\common\model\Category())->edit(input('post.'));
            if ($res['valid']){
                //执行成功
                $this->success($res['msg'],'index');exit;
            } else{
                $this->error($res['msg']);exit;
            }
        }

        $cate_id = input('param.cate_id');
        $oldData = Db::name('cate')->where('cate_id',$cate_id)->find();
        $this->assign('oldData',$oldData);
        //cate_id   cate_name   cate_pid
        //处理数据的时候不能包含自己和自己的子集数据
        $data = (new \app\common\model\Category())->getCateData($cate_id);

        $this->assign('data',$data);
        return $this->fetch();
    }

    public function del()
    {
        $cate_id = input('param.cate_id');
        $res = (new \app\common\model\Category())->del($cate_id);

        if($res['valid']) {
            $this->success($res['msg'],'index');exit;
        } else{
            $this->error($res['msg']);exit;
        }
    }

}