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



/**
 * 根据PHP各种类型变量生成唯一标识号
 * @param mixed $mix 变量
 * @return string
 */
function meke_guid($mix) {
    if (is_object($mix)) {
        return spl_object_hash($mix);
    } elseif (is_resource($mix)) {
        $mix = get_resource_type($mix) . strval($mix);
    } else {
        $mix = serialize($mix);
    }
    return md5($mix);
}



/*
 * 返回错误报告
 */

function _show_error($str){
    echo $str;
    die;
}


function Error($msg, $output = TRUE, $stop = TRUE){
    $traces = debug_backtrace();
    $bufferabove = ob_get_clean();
    require LP_MC_Err.'/error.php';
    if(TRUE == $stop)exit;
}
