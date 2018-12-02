<?php

namespace app\admin\validate;
use think\Validate;

class Flink extends Validate {
    protected $rule =   [
        'title'  => 'require|min:4',
        'url' => 'require|url',
    ];

    protected $message  =   [
        'title.require' => '用户名必须！',
        'title.min'     => '网站名称长度不小于4字符！',
        'url.require'   => '网站URL必须！',
        'url.url'   => '网站URL格式错误！',
    ];

}