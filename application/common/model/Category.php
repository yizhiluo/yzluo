<?php

namespace app\common\model;

use houdunwang\arr\Arr;
use think\Db;
use think\Model;
use think\Validate;

class Category extends Model
{
    protected $pk = 'cate_id';
    protected $table = 'blog_cate';
    public function store($data)
    {
        //执行验证
        //执行添加
        $validate = new \app\admin\validate\Category;

        if (!$validate->check($data)) {
           return ['valid'=>0,'msg'=>$validate->getError()];
        }
        $category = new Category;
        $res = $category->save($data);
        if(!$res)
        {
            //说明在数据未匹配相应的数据
            return ['valid'=>0,'msg'=>'添加失败'];
        }else{
            return ['valid'=>1,'msg'=>'添加成功'];

        }
    }
    //获取分类树状结构
    public function getAll()
    {
        //使用方法参考hdphp手册
        return  Arr::tree(Db::name('cate')->order('cate_sort desc, cate_id')->select(),'cate_name',$fieldPri='cate_id',$fieldPid='cate_pid');
    }

    public function getCateData($cate_id)
    {
        //halt(Db::name('cate')->select());
        //1.首先找到cate_id子集
            $cate_ids = $this->getSon(Db::name('cate')->select(),$cate_id);
        //2.将自己追缴进去
            $cate_ids[] = $cate_id;
        //3.找到除了他们之外的数据
       $field =  Db::name('cate')->whereNotIn('cate_id',$cate_ids)->select();
       return  Arr::tree($field,'cate_name','cate_id','cate_pid');

       //halt($field);
    }

    //找子集
    public function getSon($data,$cate_id)
    {
        static $temp = [];
        foreach ($data as $k=>$v)
        {
            if($cate_id == $v['cate_pid'])
            {
                $temp[] = $v['cate_id'];
                //递归查找所有的子集（儿子的儿子也要找）
                $this->getSon($data,$v['cate_id']);
            }
        }
        return $temp;
    }

    public function edit($data)
    {
        $validate = new \app\admin\validate\Category;

        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }

        $category = new Category;
        $res = $category->save($data,[$this->pk=>$data['cate_id']]);
        if(!$res)
        {
            //说明在数据未匹配相应的数据
            return ['valid'=>0,'msg'=>'编辑失败'];
        } else{
            return ['valid'=>01,'msg'=>'编辑成功'];
        }
    }

    public function del($cate_id)
    {
        //获取当前要删除的数据cate_pid
        $cate_pid = $this->where('cate_id',$cate_id)->value('cate_pid');
        //将要删除的$cate_id的子集数据的pid修改成cate_pid
        $this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);
        //执行当前数据的删除
        if(Category::destroy($cate_id)){

            return ['valid'=>1,'msg'=>'删除成功'];
        } else{
            return ['valid'=>0,'msg'=>'删除失败'];

        }
    }
}