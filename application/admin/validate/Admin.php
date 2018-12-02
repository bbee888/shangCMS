<?php

namespace app\admin\validate;
use think\Validate;

class Admin extends Validate {
    protected $rule =   [
        'username'  => 'require|min:5',
        'password' => 'require',
        'email' => 'email',
        'intro' => 'max:100',
    ];

    protected $message  =   [
        'username.require' => '网站名称必须！',
        'username.min'     => '网站名称长度不能小于5个字符',
        'password.require'   => '密码必须！',
        'email.email'   => 'email格式不正确！',
        'intro.max' => '备注信息最大长度不能超过100字符！'
    ];

}