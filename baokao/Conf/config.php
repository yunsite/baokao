<?php
return array(
    //'APP_DEBUG'             =>true,  //调试模式
    'URL_HTML_SUFFIX'       => '.shtml',  // URL伪静态后缀设置
    'URL_PATHINFO_DEPR'     => '-',	// PATHINFO模式下，各参数之间的分割符号
    'URL_CASE_INSENSITIVE'  => true,   // URL地址是否不区分大小写

    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
    'DB_HOST'               => '127.0.0.1', // 服务器地址
    'DB_NAME'               => 'lfy_newbaokao',
    'DB_USER'               => 'root',      // 用户名
    'DB_PWD'                => 'lanfengye',
    'DB_PORT'               => 3306,        // 端口
    'DB_PREFIX'             => 'lfy_',    // 数据库表前缀
    'DB_SUFFIX'             => '',          // 数据库表后缀

    'TOKEN_ON'=>false,  // 是否开启令牌验证
    //'URL_ROUTER_ON'=>true,   //开启url路由模式

    'HTML_CACHE_ON'=>true,  //开启静态化
    

    //开启数据缓存子目录功能
    'DATA_CACHE_SUBDIR'=>true,

     //分组配置
    'APP_GROUP_LIST'=>'Lfy,Home',   //Admin为管理后台
    //默认分组为Home分组
    'DEFAULT_GROUP'=>'Home',

);
?>