<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    protected $pk = 'id';
    protected $field = true;

    // 对密码进行加密
    public function setPasswordAttr($value)
    {
        return md5(md5($value));
    }





}