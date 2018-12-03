<?php

namespace app\admin\controller;

use app\admin\model\Article as articleModel;
use app\admin\model\Category;

class Article extends Common
{
    public function initialize()
    {
        parent::initialize();
        //分类
        $catgeroy = Category::all(['type' => 0]);
        $this->assign('category', $catgeroy);
    }

    public function index()
    {
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
        $category = new Category();
        $count = $article->count();
        $articlelist = $article->where('1=1')->limit($start, $limit)->order('id desc')->select();

        foreach ($articlelist as $k => $v) {
            $articlelist[$k]['catname'] = $category->where('catid', $articlelist[$k]['catid'])->value('catname');
        }

        //取得catname放进articlelist中
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
     * 添加文章
     *
     */

    public function add()
    {
        $category = new Category();
        $article = new articleModel();
        if (request()->isPost()) {
            $params = input('post.');
            $params['inputtime'] = time();
            $params['updatetime'] = time();
            $params['views'] = rand(10, 100); //文章点击数 给一个随机值
            $subCateCount = $category->where('pid', $params['catid'])->count();
            if ($subCateCount > 0) {
                return json(['code' => 0, 'msg' => '父栏目不能添加文章，请重新选择栏目！', 'url' => '']);
                die;
            }

            $validate = \think\Loader::validate('Article');
            if (!$validate->scene('add')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            if ($article->insert($params)) {
                return json(['code' => 1, 'msg' => '文章添加成功！', 'url' => url('index')]);
            } else {
                return json(['code' => 0, 'msg' => '文章添加失败！', 'url' => '']);
            }
        } else {
            $categorylist = $category->cateTree(0);
            $this->assign('categorylist', $categorylist);
            return $this->fetch();
        }
    }

    /*
     * 更新article
     *
     */
    public function edit()
    {
        $id = input('id/d');
        if (!$id) {
            return $this->error('编辑失败，无法获取到ID值！');
        }
        $article = new articleModel();
        $category = new Category();
        $item = $article->find($id);
        $this->assign('item', $item);
        $categorylist = $category->cateTree(0);
        $this->assign('categorylist', $categorylist);
        if (request()->isPost()) {
            $params = input('post.');
            $params['updatetime'] = time();
            $validate = \think\Loader::validate('Article');
            if (!$validate->scene('edit')->check($params)) {
                $this->error($validate->getError());
                die;
            }

            if ($article->update($params)) {
                return json(['code' => 1, 'msg' => '文章更新成功！', 'url' => url('index')]);
            } else {
                return json(['code' => 0, 'msg' => '文章更新失败！', 'url' => '']);
            }
        }
        return $this->fetch();

    }

    /*
     * 更新点击数 文章首页更新点击数，不需要返回值
     *
     */
    public function views()
    {
        if (request()->isPost()) {
            $params = input('post.');

            $article = new articleModel();
            $article->save($params, ['id' => $params['id']]);
            // if (false !== $article->save($params, ['id' => $params['id']])) {
            //     return $this->success("更新成功");
            // } else {
            //     return $this->error("更新失败");
            // }
        }
    }

    /**
     * 删除文章
     */
    public function delete()
    {
        $id = input('id/d');
        $article = new articleModel();
        $res = $article->where('id', $id)->delete();
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

}
