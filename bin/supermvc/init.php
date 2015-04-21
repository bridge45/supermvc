<?php
//定义系统路径
require LP_PATH.'/Core/Sfun/common.php';//通用用户函数库
require LP_PATH.'/Core/Sfun/function.php';//通用系统函数库
require LP_PATH.'/Core/Sfun/filter.php';//通用系统函数库
require LP_PATH.'/Pmvc/Model.class.php';//数据库相关
require LP_PATH.'/Pmvc/View.class.php';//视图
require LP_PATH.'/Pmvc/PrivateController.class.php';//控制器协助层
require LP_PATH.'/Pmvc/Controller.class.php';//控制器层

require LP_PATH.'/Core/TPL/Smarty/libs/Smarty.class.php';//控制器层

define("CACHE_PATH",APP_PATH.'/cachedata');
define('UC',Q('get.'.C('controller_tag'),C('default_controller')));//控制器
define('UA', Q('get.'.C('action_tag'),C('default_action')));//动作
debug_error_check();//调试模式检测
if(C('auto_session')) session_start();// 自动开启SESSION


function daung(){
    //实例化控制器
    $OBJ = _make_controller_obj();
    $action_name = UA;
    $OBJ->$action_name();
}

/*
 * 初始化控制器实体
 */
function _make_controller_obj(){
    $controller_name = UC;
    if(!_chkname(UC)) _show_error('控制器类名['.$controller_name.']格式不符合要求!');
    include APP_PATH.'/controller/'.$controller_name.'Controller.php';
    return new $controller_name();
}

