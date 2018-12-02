<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Session;

class Common extends Controller
{

    public function _initialize()
    {
        if(!session('username')){
            $this->error('请先登录！','Login/index');
        }

            //登录是否过期 无操作1h即为过期
//        $logintime = Session::get('admininfo.logintime');
//        if (time() - $logintime > 3600) {
//            Session::clear();
//            $this->redirect('login/index');
//        }
//        Session::set('admininfo.logintime',time());
//        $this->assign('username', $username);

            $module = strtolower(request()->module());
            $controller = strtolower(request()->controller());
            $action = strtolower(request()->action());
            $this->assign([
                'module' => $module,
                'controller' => $controller,
                'action' => $action
            ]);


    }

        /**
         * 清除缓存
         */
        function clear()
        {
            $result = del_dir(TEMP_PATH);
            if ($result) {
                return json(['status' => 1, 'msg' => '缓存清除成功！']);
            } else {
                return json(['status' => 0, 'msg' => '缓存清除失败！']);
            }
        }


        /*
         * 空操作
         */
    public function _empty()
        {
            abort(404, '页面不存在啊！');
        }

}