<?php

// [ PHP版本检查 ]
header("Content-type: text/html; charset=utf-8");
if (version_compare(PHP_VERSION, '5.5', '<')) {
    die('PHP版本过低，最少需要PHP5.5，请升级PHP版本！');
}

// [ 应用入口文件 ]
if (!defined('__PUBLIC__')) {
    $_public = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
    define('__PUBLIC__', (('/' == $_public || '\\' == $_public) ? '' : $_public).'/public');
}

//开启页面调试工具
define('APP_DEBUG',true);


// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');

// 定义后台入口文件
define('ADMIN_FILE', 'admin.php');

// 检查是否安装
if(!is_file(APP_PATH . '/install/data/install.lock')){
    define('BIND_MODULE', 'install');
}

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
