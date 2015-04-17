<?php
//用户配置文件
return array(
    'mode' => 'debug1', // 应用程序模式，默认为调试模式
    'launch' => array(
        'a'=>'aaaaaaa',
        'b'=>array('c'=>'ccccccc')

        ), // 自动执行点的根节点

    'auto_load_controller' => array('spArgs1'), // 控制器自动加载的扩展类名
    'auto_load_model' => array('spPager1','spVerifier1','spCache1','spLinker1'), // 模型自动加载的扩展类名
);
