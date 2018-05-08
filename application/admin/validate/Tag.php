<?php
/**
 * Created by PhpStorm.
 * User: ips
 * Date: 2018/4/24
 * Time: 16:57
 */
namespace  app\admin\validate;
use think\Validate;

class Tag extends Validate
{
    protected  $rule = [
        'tag_name' => 'require',

    ];

    protected $message = [
        'tag_name.require' => '请输入标签名称',

    ];
}