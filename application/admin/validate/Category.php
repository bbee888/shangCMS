<?php

namespace app\admin\validate;
use think\Validate;

class Category extends Validate {
    protected $rule =   [
        'catname'  => 'require|min:4',
        'catdir'  => 'alphaNum',
    ];

    protected $message  =   [
        'catname.require' => '栏目名称必须！',
        'catname.max'     => '栏目名称长度不能太短！',
        'catdir.alphaNum' => '栏目目录只能为字母和数字',
    ];

}