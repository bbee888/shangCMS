<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Admin as adminModel;

class Admin extends Common
{
    public function index()
    {
        if (request()->isPost()) {
            $page = input("post.page") ? input("post.page") : 1;
            $page = intval($page);
            $limit = input("post.limit") ? input("post.limit") : 1;
            $limit = intval($limit);
            $start = $limit * ($page - 1);

            $admin = new adminModel();
            $count = $admin->count();
            $adminlist = $admin->where('1=1')->limit($start, $limit)->order('id asc')->select();
            if ($adminlist) {
                $code = 0;
                $msg = "success!";
            } else {
                $code = 1;
                $msg = "error!";
            }
            return json(['code' => $code, 'msg' => $msg, 'count' => $count, 'data' => $adminlist]);
        }

        return $this->fetch();
    }


    /**
     * 添加管理员
     */
    public function add()
    {
        $admin = new adminModel();
        if (request()->isPost()) {
            $params = input('post.');
            $params['create_time'] = time();
            $params['update_time'] = time();
            $params['logintime'] = time();
            $params['loginip'] = $this->request->ip();
            $params['password'] = $admin->setPasswordAttr($params['password']);

            $validate = \think\Loader::validate('Admin');
            if (!$validate->scene('add')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            
            if ($admin->insert($params)) {
                return json(['code' => 1, 'msg' => '管理员添加成功！', 'url' => 'index']);
            } else {
                return json(['code' => 0, 'msg' => '管理员添加失败！', 'url' => '']);
            }
        } else {
            return $this->fetch();
        }

    }

    /*
     * 更新管理员
     *
     */
    public function edit()
    {
        $id = input('id/d');
        $admin = new adminModel();
        $item = $admin->find($id);
        $this->assign('item', $item);
        if (request()->isPost()) {
            $params = input('post.');
            $params['update_time'] = time();

            if ($params['newpassword']) {
                $params['password'] = $admin->setPasswordAttr($params['newpassword']);
            }

            if (false !== $admin->update($params)) {
                return json(['code' => 1, 'msg' => '更新成功！', 'url' => 'index']);
            } else {
                return json(['code' => 0, 'msg' => '更新失败！', 'url' => '']);
            }
        }
        return $this->fetch();
    }

    /**
     * 删除管理员
     */
    public function delete()
    {
        $id = input('id/d');
        $admin = new adminModel();
        $res = $admin->where('id', $id)->delete();
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        } else {
            return ['code' => 0, 'msg' => '删除失败'];
        }
    }
}
