<?php
//项目入口文件

// 定义框架路径
define('THINK_PATH', 'lfy_system');
//定义项目名称和路径
define('APP_NAME', 'lfynewbaokao');
define('APP_PATH', '.');
// 加载框架入口文件
// 项目的ALLINONE模式，开发环境未开启
//define('RUNTIME_ALLINONE', true);
require(THINK_PATH."/LFY.php");
//实例化一个网站应用实例
App::run();
?>
