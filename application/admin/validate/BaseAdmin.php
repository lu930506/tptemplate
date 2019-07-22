<?php

namespace app\admin\validate;

use think\Validate;

class BaseAdmin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'account'=>'require|max:25',
        'email'=>'email',
        '__token__' => 'require|token',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'account.require'=>'账号不能为空',
        'account.max:25'=>'账号长度不能超25位',
        'email'=>'邮箱格式不正确',
    ];
}
