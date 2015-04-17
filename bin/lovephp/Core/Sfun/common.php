<?php
/*
 * lovephp 系统主函数
 */

/**
 * 获取配置参数
 * @param string $name 变量名称
 * @return string
 * @example | null 返回全部 | a.b.c 这样的格式
 */
function C($name = null)
{
    static $config = array();
    $config || $config = _get_config();
    // 无参数时获取所有
    if (empty($name)) {
        return $config;
    }
    $names = explode('.', $name);
    foreach ($names as $name) {
        if (isset($config[$name])) {
            $config = $config[$name];
        } else {
            return null;
        }
    }
    return $config;
}

/*
 * @name 获取参数(所有的请求都要走这里)
 * @param string $qstr 获取值字符串
 * @param mixed  $default 默认值
 * @param mixed  $filter 参数过滤方法
 * @param mixed  $err_msg 不存在报警信息
 * @return mixed
 */
function Q($qstr, $default = '', $empty_msg = null, $filter = null, $filter_msg = null)
{
    if (strpos($qstr, '.')) { // 指定参数来源
        list($type, $name) = explode('.', $qstr, 2);
    } else {
        $type = 'get';
        $name = $qstr;
    }

    switch (strtolower($type)) {
        case 'get'     :
            $Q = $_GET;
            break;
        case 'post'    :
            $Q = $_POST;
            break;
        case 'request'    :
            $Q = $_REQUEST;
            break;
        case 'session' :
            $Q = $_SESSION;
            break;
        case 'cookie'  :
            $Q = $_COOKIE;
            break;
        default:
            return null;
    }

    if(!isset($Q[$name])){
        if($empty_msg)
            showError($empty_msg);
        else
            return $default;
    }

    if($filter){
        if(!AlFilter($Q[$name],$filter)){
            $filter_msg || $filter_msg = '验证不通过!';
            showError($filter_msg);
        }
    }

    return $Q[$name];
}

/*
 * 显示错误
 */
function showError($msg){
    echo 'showError'.$msg;
    exit;
}


//白名单过滤模式开始
function AlFilter($str=NULL,$operate,$ext=NULL){
    $str = trim(str_replace(PHP_EOL, '', $str));//去换行机制
    if(!$str) return 0;
    //匹配模式 $pattern
    $Ap="\x{4e00}-\x{9fff}".'0-9a-zA-Z\@\#\$\%\^\&\*\(\)\!\,\.\?\-\+\=';//全部字符串
    $Cp="\x{4e00}-\x{9fff}";//汉字
    $Dp='0-9';//数字
    $Wp='a-zA-Z';//字母
    $Tp='@#$%^&*()-+=?';//特殊符号
    $_p='_';//下划线

    $pattern="/^[";
    $OArr=str_split(strtolower($operate));//拆分操作符
    if (in_array('a', $OArr)) $pattern.=$Ap;
    if (in_array('c', $OArr)) $pattern.=$Cp;
    if (in_array('d', $OArr)) $pattern.=$Dp;
    if (in_array('w', $OArr)) $pattern.=$Wp;
    if (in_array('t', $OArr)) $pattern.=$Tp;
    if (in_array('_', $OArr)) $pattern.=$_p;
    if($ext) $pattern.=$ext;
    $pattern.="]+$/u";
    if(!preg_match($pattern,$str)){
        return 0;
    }else{
        return $str;
    }
}

/*
 * 调试模式错误判断
 */
function debug_error_check(){
    if (APP_DEBUG) {
        if( substr(PHP_VERSION, 0, 3) == "5.3" ){
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
        }else{
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        }
    } else {
        error_reporting(0);
    }
}