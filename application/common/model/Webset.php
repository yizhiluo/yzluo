<?php

namespace app\common\model;

use think\Model;

class Webset extends Model
{
    protected $pk = 'webset_id';
    protected $table = 'blog_webset';

	/**
	 * 执行编辑
	 */
    public function edit($data)
	{

        //1.执行验证
        $validate = new \app\admin\validate\Webset;

        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }

        $Webset = new Webset;

        $res = $Webset->save($data,$data['webset_id']);

		if($res)
		{
			return ['valid'=>1,'msg'=>'操作成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
	}
}
