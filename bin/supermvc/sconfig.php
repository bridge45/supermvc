<?php
return array(
    'auto_session' => true,//自动开启session支持

    'controller_tag' => 'c',  // 控制器变量标识
    'action_tag' => 'a',  // 动作标识
    'default_controller' => 'index', // 默认的控制器名称
    'default_action' => 'index',  // 默认的动作名称

    'default_theme' => 'home', //模块
    'default_tem_ext' => '.tpl', //模块

    'session' => array(
        'prefix' => 'supermvc',//session 前缀
        'expire' => '3600',//
        'path' => '/',// Cookie路径
        'domain' => '', // Cookie有效域名
        'httponly' => '',// Cookie httponly设置
    ),
    'cookie' => array(
        'prefix' => 'supermvc',//前缀
    ),
    'debug' => array(
        'allow_ip' => '*'//允许调试IP,逗号隔开,支持 *表示所有
    ),
    'db' => array(  // 数据库连接配置
        'driver' => 'mysql',   // PDO驱动类型
        'host' => '10.209.79.4', // 数据库地址
        'port' => 3306,        // 端口
        'user' => 'root',     // 用户名
        'pwd' => 'qwe123',      // 密码
        'database' => 'test',      // 库名称
        'prefix' => '',           // 表前缀
    ),
    'cache' => array(  //缓存配置
        'driver' => 'mem', //驱动类型
        'host' => '127.0.0.1', //地址
        'port' => 11211,      //端口
        'expire' => 3600,      //端口
        'hash' => true,   //主动hash
        'prefix' => 'supermvc',   //缓存md5_前缀
    ),
    'error' =>array(
        'show_error_line_before' => 3,//显示错误代码前几行
        'show_error_line_after' => 3,//显示错误代码后几行
    ),
    'view' => array(
        'config' =>array(
            'template_dir' => APP_PATH.'/template', // 模板目录
            'tmpc_dir' => APP_PATH.'/cachedata/tmpc', // 编译目录
            'cache_dir' => APP_PATH.'/cachedata/cache', // 缓存目录
            'left_delimiter' => '<{',  // smarty左限定符
            'right_delimiter' => '}>', // smarty右限定符
            'force_compile' => true, // smarty右限定符
            'cache_lifetime' => true, // smarty右限定符
        ),
   )
);