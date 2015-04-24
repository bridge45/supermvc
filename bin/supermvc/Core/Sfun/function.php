<?php

/*
 * 获取配置文件的值
 */
function _get_config(){
    $sys_config  = include LP_MAIN."/sconfig.php";
    $user_config = include LP_CON."/config.php";
    // 载入配置文件
    return  _config_merge($sys_config,$user_config);
}

/*
 * 配置文件去重
 */
function _config_merge($syscon,$usercon){
    $config = $syscon;
    if (is_array($usercon)){
        foreach ($usercon as $key => $val){
            if (is_array($usercon[$key])){
                $config[$key] = isset($config[$key]) && is_array($config[$key]) ? _config_merge($config[$key], $usercon[$key]) : $usercon[$key];
            }else{
                $config[$key] = $val;
            }
        }
    }
    return $config;
}


/*
 * 返回错误报告
 */

function _show_error($str){
    echo $str;
    die;
}
