<?php

namespace app\admin\controller;

use app\admin\model\Category;
use think\Db;

class Page extends Common
{
    // public function initialize()
    // {
    //     parent::initialize();
    //     //分类
    //     $catgeroy = Category::all(['type' => 1]);
    //     $this->assign('category', $catgeroy);
    // }

    public function index()
    {
        $category = new Category();
        $pagelist = $category->cateTree(1);
        $this->assign('pagelist', $pagelist);
        return $this->fetch();
    }

    public function articlelist()
    {
        $page = input("get.page") ? input("get.page") : 1;
        $page = intval($page);
        $limit = input("get.limit") ? input("get.limit") : 1;
        $limit = intval($limit);
        $start = $limit * ($page - 1);

        $article = new articleModel();
        $count = $article->count();
        $articlelist = $article->where('1=1')->limit($start, $limit)->order('id asc')->select();
        if ($count >= 1 && $articlelist) {
            $code = 0;
            $msg = "success!";
        } else {
            $code = 1;
            $msg = "暂无数据！";
        }
        return json(['code' => $code, 'msg' => $msg, 'count' => $count, 'data' => $articlelist]);
    }


    /**
     * 添加单网页
     */
    public function add()
    {
        $catid = input('param.catid/d', 0);
        $category = new Category();
        if (request()->isPost()) {
            $params = input('post.');
            $params['createtime'] = time();

            $validate = \think\Loader::validate('Category');
            if (!$validate->scene('add')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            if ($category->insert($params)) {
                return json(['code' => 1, 'msg' => '单网页添加成功！', 'url' => url('index')]);
            } else {
                return json(['code' => 0, 'msg' => '单网页添加失败！', 'url' => '']);
            }
        } else {
            $categorylist = $category->cateTree(1);
            $this->assign('categorylist', $categorylist);
            $this->assign("catid", $catid);
            return $this->fetch();
        }
    }
    
    /*
     * 单网页更新
     *
     */
    public function edit()
    {
        $catid = input('catid/d');
        $category = new Category();
        $item = $category->find($catid);
        $this->assign('item', $item);
        $categorylist = $category->cateTree(1);
        $this->assign('categorylist', $categorylist);
        if (request()->isPost()) {
            $params = input('post.');
            if($catid == $params['pid']){
                return json(['code' => 0, 'msg' => '不能选择自己为父栏目，请重新选择！', 'url' => '']);
            }
            $validate = \think\Loader::validate('Category');
            if (!$validate->scene('edit')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            if ($category->update($params)) {
                return json(['code' => 1, 'msg' => '单网页更新成功！', 'url' => url('index')]);
            } else {
                return json(['code' => 0, 'msg' => '单网页更新失败！', 'url' => '']);
            }
        }
        return $this->fetch();

    }

    /**
     * 删除
     */
    public function delete()
    {
        $catid = input('param.catid');
        $category = new Category();
        $res = $category->where('catid', $catid)->delete();
        if ($res) {
            return json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return json(['status' => 0, 'msg' => '删除失败']);
        }
    }


    


    

}
