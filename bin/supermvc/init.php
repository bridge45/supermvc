<?php
//定义系统路径
define('LP_CACHE',APP_PATH.'/cachedata');
define('LP_C',APP_PATH.'/controller');
define('LP_M',APP_PATH.'/model');
define('LP_V',APP_PATH.'/template');

define('LP_BIN',APP_PATH.'/bin');
    define('LP_CON',LP_BIN.'/conf');
    define('LP_EXT',LP_BIN.'/extent');
    define('LP_MAIN',LP_BIN.'/supermvc');
        define('LP_M_CORE',LP_MAIN.'/Core');
            define('LP_MC_CACHE',LP_M_CORE.'/Cache');
            define('LP_MC_DB',LP_M_CORE.'/DB');
            define('LP_MC_Debug',LP_M_CORE.'/Debug');
            define('LP_MC_SFUN',LP_M_CORE.'/Sfun');
            define('LP_MC_TPL',LP_M_CORE.'/TPL');
            define('LP_MC_Err',LP_M_CORE.'/Error');
        define('LP_M_PMVC',LP_MAIN.'/Pmvc');

//加载系统配置
require LP_MC_SFUN.'/common.php';//通用用户函数库
require LP_MC_SFUN.'/function.php';//通用系统函数库
require LP_MC_SFUN.'/filter.php';//通用系统函数库

//MVC基类
require LP_M_PMVC.'/Model.class.php';//数据库相关
require LP_M_PMVC.'/View.class.php';//视图
require LP_M_PMVC.'/PrivateController.class.php';//控制器协助层
require LP_M_PMVC.'/Controller.class.php';//控制器层

//视图框架
require LP_MC_TPL.'/Smarty/libs/Smarty.class.php';//控制器层

//缓存
require LP_MC_CACHE.'/Cache.class.php';

//调试
if(APP_DEBUG)
    require LP_MC_Debug.'/ChromePhp.class.php';

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


