<?php

namespace app\admin\validate;
use think\Validate;

class Article extends Validate {
    protected $rule =   [
        'title'  => 'require|max:80',
        'catid' => 'require',
        'content' => 'require',
    ];

    protected $message  =   [
        'title.require' => '文章标题不能为空',
        'title.max'     => '文章标题最多不能超过80个字符',
        'catid.require'   => '请先选择文章分类',
        'content.require'   => '请填写文章内容',
    ];

}