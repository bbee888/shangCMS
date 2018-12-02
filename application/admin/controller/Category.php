<?php

namespace app\admin\controller;

use app\admin\model\Category as categoryModel;
use app\admin\model\Article;
use think\Db;

class Category extends Common
{
    public function initialize()
    {
        parent::initialize();
        $this->category_model = new categoryModel();
        $category = $this->category_model->cateTree(2);
        $this->assign('category', $category);
    }

    public function index()
    {
        $category = new categoryModel();
        $article = new Article();
        $categorylist = $category->cateTree(2);

        //统计每个栏目下的文章
        foreach ($categorylist as $k => $v) {
            $categorylist[$k]['acount'] = $article->where('catid', $categorylist[$k]['catid'])->count();
        }
        $this->assign('categorylist', $categorylist);
        return $this->fetch();
    }

    public function categorylist()
    {
        $page = input("get.page") ? input("get.page") : 1;
        $page = intval($page);
        $limit = input("get.limit") ? input("get.limit") : 1;
        $limit = intval($limit);
        $start = $limit * ($page - 1);

        $category = new categoryModel();
        $count = $category->count();
        $categorylist = $category->where('1=1')->limit($start, $limit)->order('catid asc')->select();
        if ($count >= 1 && $categorylist) {
            $code = 0;
            $msg = "success!";
        } else {
            $code = 1;
            $msg = "暂无数据！";
        }
        return json(['code' => $code, 'msg' => $msg, 'count' => $count, 'data' => $categorylist]);
    }


    /**
     * 添加栏目
     */
    public function add()
    {
        $catid = input('param.catid/d', 0);
        $type = input('param.type/d', 0);
        $category = new categoryModel();
        if (request()->isPost()) {
            $params = input('post.');
            $params['createtime'] = time();

            $validate = \think\Loader::validate('Category');
            if (!$validate->scene('add')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            if ($category->insert($params)) {
                return json(['code' => 1, 'msg' => '栏目添加成功！', 'url' => url('index')]);
            } else {
                return json(['code' => 0, 'msg' => '栏目添加失败！', 'url' => '']);
            }
        } else {
            $categorylist = $category->cateTree(2);
            $this->assign('categorylist', $categorylist);
            $this->assign("catid", $catid);
            $this->assign("type", $type);
            return $this->fetch();
        }
    }

    /*
     * 更新栏目
     *
     */
    public function edit()
    {
        $catid = input('catid/d');
        $category = new categoryModel();
        $item = $category->find($catid);
        $this->assign('item', $item);
        $categorylist = $category->cateTree(2);
        $this->assign('categorylist', $categorylist);
        if (request()->isPost()) {
            $params = input('post.');
            if ($catid == $params['pid']) {
                return json(['code' => 0, 'msg' => '不能选择自己为父栏目，请重新选择！', 'url' => '']);
            }
            $validate = \think\Loader::validate('Category');
            if (!$validate->scene('edit')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            if ($category->update($params)) {
                return json(['code' => 1, 'msg' => '栏目更新成功！', 'url' => url('index')]);
            } else {
                return json(['code' => 0, 'msg' => '栏目更新失败！', 'url' => '']);
            }
        }
        $this->assign('catid', $catid);
        return $this->fetch();

    }

    /**
     * 删除
     */
    public function delete()
    {
        $catid = input('param.catid');
        $category = new categoryModel();
        $article = new Article();
        //如果有子栏目，先要求删除子栏目和子栏目里的文章
        $scount = $category->where(array('pid' => $catid))->count();
        if ($scount) {
            return json(['code' => 0, 'msg' => '请先删除子栏目！']);
        }
        //如果栏目下有文章，请先清空文章
        $acount = $article->where(array('catid' => $catid))->count();
        if ($acount) {
            return json(['code' => 0, 'msg' => '请先清空栏目下的文章！']);
        }

        if ($scount == 0 && $acount == 0) {
            $res = $category->where('catid', $catid)->delete();
            if ($res) {
                return ['code' => 1, 'msg' => '栏目删除成功'];
            } else {
                return ['code' => 0, 'msg' => '栏目删除失败'];
            }
        }
    }
}
