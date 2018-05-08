<?php

namespace app\common\model;

    use houdunwang\crypt\Crypt;
    use think\Db;
    use think\Model;
    use think\Validate;

class Admin extends Model
{
    protected $pk = 'admin_id';
    protected $table = 'blog_admin';

    public function login($data)
    {
        //1.执行验证
        $validate = new \app\admin\validate\Admin;

        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        $userdata['admin_username'] = $data['admin_username'];
        $userdata['admin_password'] = Crypt::encrypt($data['admin_password']);
        //2.对比用户名和密码是否正确
        $userInfo =  Db::name('admin')->where($userdata)->select();
        if(!$userInfo)
        {
            //说明在数据未匹配相应的数据
            return ['valid'=>0,'msg'=>'用户名或密码不正确'];
        }
        //3.将用户信息存入到session
        session('admin.admin_id',$userInfo[0]['admin_id']);
        session('admin.admin_username',$userInfo[0]['admin_username']);
        return ['valid'=>1,'msg'=>'登录成功'];
    }
    //修改密码
    public function pass($data)
    {

        //1.执行验证
        $validate = new Validate([
            'admin_password' => 'require',
            'new_password' => 'require',
            'confirm_password' => 'require|confirm:new_password',
        ],[
            'admin_password.require' => '请输入原始密码',
            'new_password.require' => '请输入新密码',
            'confirm_password.require' => '请输入确认密码',
            'confirm_password.confirm' => '确认密码与新密码不一致',
        ]);
        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        //2.原始密码的判断
        $userdata['admin_id'] = session('admin.admin_id');
        $userdata['admin_password'] = Crypt::encrypt($data['admin_password']);
        $userInfo =  Db::name('admin')->where($userdata)->select();
        if(!$userInfo){
            return ['valid'=>0,'msg'=>'原始密码不正确'];
        }
        //3.修改密码
        $res = $this->save([
            'admin_password' => Crypt::encrypt($data['new_password'])],
            [$this->pk =>session('admin.admin_id')
        ]);
        if($res){
            return ['valid'=>1,'msg'=>'密码修改成功'];
        } else{
            return ['valid'=>0,'msg'=>'密码修改失败'];

        }
    }
}
