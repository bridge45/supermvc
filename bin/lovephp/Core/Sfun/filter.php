<?php

/*
 * 常规命名检测
 */
function _chkname($str){
    return AlFilter($str,'W_D');
}




/*
 * 白名单公共过滤函数
 */
function AlFilter($str = NULL, $operate, $ext = NULL)
{
    $str = trim(str_replace(PHP_EOL, '', $str));//去换行机制
    if (!$str) return 0;
    //匹配模式 $pattern
    $Ap = "\x{4e00}-\x{9fff}" . '0-9a-zA-Z\@\#\$\%\^\&\*\(\)\!\,\.\?\-\+\=';//全部字符串
    $Cp = "\x{4e00}-\x{9fff}";//汉字
    $Dp = '0-9';//数字
    $Wp = 'a-zA-Z';//字母
    $Tp = '@#$%^&*()-+=?';//特殊符号
    $_p = '_';//下划线

    $pattern = "/^[";
    $OArr = str_split(strtolower($operate));//拆分操作符
    if (in_array('a', $OArr)) $pattern .= $Ap;
    if (in_array('c', $OArr)) $pattern .= $Cp;
    if (in_array('d', $OArr)) $pattern .= $Dp;
    if (in_array('w', $OArr)) $pattern .= $Wp;
    if (in_array('t', $OArr)) $pattern .= $Tp;
    if (in_array('_', $OArr)) $pattern .= $_p;
    if ($ext) $pattern .= $ext;
    $pattern .= "]+$/u";
    if (!preg_match($pattern, $str)) {
        return 0;
    } else {
        return $str;
    }
}