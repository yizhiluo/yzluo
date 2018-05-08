<?php

namespace app\common\model;

use think\Model;

class Tag extends Model
{
    protected $pk = "tag_id";//主键
    protected $table = "blog_tag"; //数据表

    public function store($data)
    {
        //1.执行验证
        $validate = new \app\admin\validate\Tag;

        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }

        $Tag = new Tag;
        $res = $Tag->save($data,$data['tag_id']);
        if(!$res)
        {
            //说明在数据未匹配相应的数据
            return ['valid'=>0,'msg'=>'添加失败'];
        } else{
            return ['valid'=>1,'msg'=>'添加成功'];

            }
    }
}
