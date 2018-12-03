<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Request;
use app\admin\model\System as systemModel;

class System extends Common
{
	public function index()
	{

		$system = new systemModel();
		if (!request()->isAjax()) {
			$list = $system::all();
			$slist = [];

			foreach ($list as $key => $item) {
				list($pk, $ck) = explode('_', $item['name']);
				$slist[$pk][$ck] = ['name' => $item['name'], 'title' => $item['title'], 'tvalue' => $item['tvalue'], 'value' => $item['value'], 'remark' => $item['remark'], 'groupid' => $item['groupid']];

			}
			// dump($slist);
			$this->assign('slist', $slist);
			return $this->fetch();
		} else {
            //插入、更新操作
			try {
				$params = input('post.');
				foreach ($params as $name => $value) {
					$flag = $system->where('name', $name)->update(['value' => $value]);
				}
			} catch (Exception $e) {

				return json(['status' => 0, 'msg' => '更新操作异常，请稍后重试', 'url' => '']);
			}

			return json(['status' => 1, 'msg' => '更新成功', 'url' => '']);
		}
	}


}
