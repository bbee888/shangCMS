<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Index extends Common
{
	public function index()
	{
		$count['flink'] = DB('flink')->where("1=1")->count(); //友情链接总数
		$count['admin'] = DB('admin')->where("1=1")->count(); //管理员总数
		$count['article'] = DB('article')->where("1=1")->count(); //文章总数
		$count['category'] = DB('category')->where("1=1")->count(); //栏目总数

		$this->assign('count', $count);
		$this->assign('sys_info', $this->get_sys_info());
		return $this->fetch();
	}

	public function get_sys_info()
	{
		$sys_info['os'] = PHP_OS;
		$sys_info['zlib'] = function_exists('gzclose') ? 'YES' : 'NO';//zlib
		$sys_info['safe_mode'] = (boolean)ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off		
		$sys_info['timezone'] = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
		$sys_info['curl'] = function_exists('curl_init') ? 'YES' : 'NO';
		$sys_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv'] = phpversion();
		$sys_info['fileupload'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown';
		$sys_info['max_ex_time'] = @ini_get("max_execution_time") . 's'; //脚本最大执行时间
		$sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
		$sys_info['domain'] = $_SERVER['HTTP_HOST'];
		$sys_info['memory_limit'] = ini_get('memory_limit');
		$sys_info['version'] = file_get_contents(APP_PATH . 'admin/version.php');
		$mysqlinfo = Db::query("SELECT VERSION() as version");
		$sys_info['mysql_version'] = $mysqlinfo[0]['version'];
		if (function_exists("gd_info")) {
			$gd = gd_info();
			$sys_info['gdinfo'] = $gd['GD Version'];
		} else {
			$sys_info['gdinfo'] = "未知";
		}
		return $sys_info;
	}

	public function upload(){
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $result['code'] = 1;
            $result['msg'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result['url'] = __PUBLIC__.'/uploads/'. $path;
            return $result;
        }else{
            // 上传失败获取错误信息
            $result['code'] =0;
            $result['msg'] = '图片上传失败!';
            $result['url'] = '';
            return $result;
        }
    }

	//编辑器图片上传
    public function editUpload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $result['code'] = 0;
            $result['msg'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result['data']['src'] = __PUBLIC__.'/uploads/'. $path;
            $result['data']['title'] = $path;
            return json_encode($result,true);
        }else{
            // 上传失败获取错误信息
            $result['code'] =1;
            $result['msg'] = '图片上传失败!';
            $result['data'] = '';
            return json_encode($result,true);
        }
	}
	//多图上传
    public function upImages(){
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $result['code'] = 0;
            $result['msg'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result["src"] = '/uploads/'. $path;
            return $result;
        }else{
            // 上传失败获取错误信息
            $result['code'] =1;
            $result['msg'] = '图片上传失败!';
            return $result;
        }
    }

}
