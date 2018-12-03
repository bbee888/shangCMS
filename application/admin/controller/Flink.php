<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Flink as flinkModel;

class Flink extends Common
{
    public function index()
    {
        return $this->fetch();
    }

    public function flinklist()
    {
        $page = input("get.page") ? input("get.page") : 1;
        $page = intval($page);
        $limit = input("get.limit") ? input("get.limit") : 1;
        $limit = intval($limit);
        $start = $limit * ($page - 1);

        $flink = new flinkModel();
        $count = $flink->count();
        $flist = $flink->where('1=1')->limit($start, $limit)->order('id asc')->select();
        if ($count >= 1 && $flist) {
            $code = 0;
            $msg = "success!";
        } else {
            $code = 1;
            $msg = "无数据";
        }
        // 这里code=0表示成功，是layui固定要求的写法。
        return json(['code' => $code, 'msg' => $msg, 'count' => $count, 'data' => $flist]);
    }

    /**
     * 添加友情链接
     */
    public function add()
    {
        if (request()->isPost()) {
            $status = input('status/d') ? input('status/d') : '0';
            $data = [
                'title' => input('title'),
                'url' => input('url'),
                'description' => input('description'),
                'createtime' => time(),
                'status' => $status,
            ];
            $validate = \think\Loader::validate('Flink');
            if (!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
                die;
            }

            $flink = new flinkModel();
            if ($flink->insert($data)) {
                return json(['code' => 1, 'msg' => '友情链接添加成功！', 'url' => 'index']);
            } else {
                return json(['code' => 0, 'msg' => '友情链接添加失败！', 'url' => '']);
            }
        } else {
            return $this->fetch();
        }

    }

    /*
     * 更新友链信息
     *
     */
    public function edit()
    {
        $id = input('id/d');
        if (!$id) {
            return $this->error('编辑失败，无法获取到ID值！');
        }
        $flink = new flinkModel();
        $item = $flink->find($id);
        $this->assign('item', $item);
        if (request()->isPost()) {
            $status = input('status/d') ? input('status/d') : '0';
            $data = [
                'id' => $id,
                'title' => input('title'),
                'url' => input('url'),
                'description' => input('description'),
                'createtime' => time(),
                'status' => $status
            ];

            $validate = \think\Loader::validate('Flink');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
                die;
            }

            if (false !== $flink->update($data)) {
                return json(['code' => 1, 'msg' => '友情链接更新成功！', 'url' => 'index']);
            } else {
                return json(['code' => 0, 'msg' => '友情链接更新失败！', 'url' => '']);
            }
        }
        return $this->fetch();

    }

    /**
     * 删除友链
     */
    public function delete()
    {
        $id = intval(input('id'));
        $flink = new flinkModel();
        $res = $flink->where('id', $id)->delete();
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }
}
