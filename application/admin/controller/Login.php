<?php

namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Admin as adminModel;
use app\admin\validate\Admin;


class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }


    public function login()
    {
        $admin = new adminModel();
        $username = input('post.username');
        $password = input('post.password');
        $captcha = input('post.captcha');
        if (!$username || !$password) {
            return array('status' => 0, 'msg' => '用户名和密码不能为空');
        }

        if(!captcha_check($captcha)){
            return array('status' => 0, 'msg' => '请输入正确的验证码');
        }

        $info = $admin->where(['username' => $username])->find();
        $password = md5(md5($password));

        if (!$info || $password != $info['password']) {
            exit(json_encode(array('status' => 0, 'msg' => '用户名或密码错误，请重新输入')));
        }
        if ($info['islock'] == 1) {
            exit(json_encode(array('status' => 0, 'msg' => '您的账户已被锁定，请联系超级管理员')));
        }
        session('username',$username);
        session('uid',$info['id']);
        session('logintime',time());
        session('loginip',getIp());
        $admin->save(['logintime' => time()],['id' => $info['id']]);//数据通过模型自动完成更新

        return json(['status' => 1, 'msg' => '登录成功', 'url' => url('index/index')]);
        
    }

    public function logout(){
        session(null);
        $this->success('退出成功！','Login/index');
    }
}
