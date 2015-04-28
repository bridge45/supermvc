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
    //echo $name."\n";
    static $config = array();
    $config || $config = _get_config();
    // 无参数时获取所有
    if (empty($name)) {
        return $config;
    }
    $config_var = $config;//避免修改出错
    $names = explode('.', $name);
    foreach ($names as $name) {
        if (isset($config_var[$name])) {
            $config_var = $config_var[$name];
        } else {
            return null;
        }
    }
    return $config_var;
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


/**
 * 缓存管理
 * @param mixed $name 缓存名称，如果为数组表示进行缓存设置
 * @param mixed $value 缓存值
 * @param mixed $options 缓存参数
 * @return mixed
 */
function S($key,$value='',$expire=null) {
    if(isset($_GET['_clear_cache'])&&$_GET['_clear_cache']){//更新缓存机智
        if(!isset($options['clear']))
            S($key,null,array('clear'=>1));
    }
    if(isset($_GET['_flush_cache'])&&$_GET['_flush_cache']) return false;//绕过缓存机制

    //单例
    static $cache   =   '';
    $cache || $cache = Cache::getInstance();
    if(''=== $value){ // 获取缓存
        return $cache->get($key);
    }elseif(is_null($value)) { // 删除缓存
        return $cache->rm($key);
    }else { // 缓存数据
        return $cache->set($key, $value, $expire);
    }
}


/*
 * session管理
 */
function session($key = '',$val = ''){;
    if(!isset($_SESSION)){
        session_start();
    }
    $prefix = C('session.prefix');
    if ('' === $key)//获取全部
        return $_SESSION[$prefix];
    if($key === null){
        unset($_SESSION[$prefix]);
    }
    if ('' === $val)//获取$key
        return isset($_SESSION[$prefix][$key]) ? $_SESSION[$prefix][$key] : '';
    if (is_null($val)) {//删除session
        unset($_SESSION[$prefix][$key]);
    }
    $_SESSION[$prefix][$key] = $val;
    return TRUE;
}

/*
 * cookie管理
 */

function cookie($key = '',$val = ''){
    $con = C('cookie');
    if(!empty($con['httponly'])){
        ini_set("session.cookie_httponly", 1);
    }
    if ('' === $key)//获取全部
        return $_COOKIE;
    if($key === null){//删除全部
        foreach ($_COOKIE as $key => $tpm) {
            if (0 === strpos($key, $con['prefix']) || $val) {
                setcookie($key, '', time() - 3600, $con['path'], $con['domain']);
                unset($_COOKIE[$key]);
            }
        }
        return true;
    }

    $key = $con['prefix'] ? $con['prefix'].'_'.$key : $key;
    if ('' === $val)//获取$key
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : '';
    if (is_null($val)) {//删除session
        setcookie($key, '', time() - 3600, $con['path'], $con['domain']);
        unset($_COOKIE[$key]);
    }
    $expire = !empty($con['expire']) ? time() + intval($con['expire']) : 0;
    setcookie($key, $val, $expire, $con['path'], $con['domain']);
    return TRUE;
}

/*
 * 显示错误
 */
function showError($msg){

    require LP_MC_Err.'/error.php';
    exit;
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


function debug($args,$type = 'log'){
    if(!APP_DEBUG) return;
    if(!in_array($type,array('log','group','groupEnd','groupCollapsed','warn','error','info','table')))
        Error('debug type not defined!');
    ChromePhp::$type($args);
}