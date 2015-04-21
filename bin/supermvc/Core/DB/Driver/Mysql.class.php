<?php

/**
 * db_mysql MySQL数据库的驱动支持
 */
class Mysql implements DB
{

    /**
     * 数据库链接句柄
     */
    public $conn;
    /**
     * 执行的SQL语句记录
     */
    public $arrSql;


    /**
     * 构造函数
     */
    public function __construct($db_con)
    {
        $this->conn = @mysql_pconnect($db_con['host'] . ":" . $db_con['port'], $db_con['user'], $db_con['pwd']) or _show_error("数据库链接错误 : " . mysql_error());
        mysql_select_db($db_con['database'], $this->conn) or _show_error("无法找到数据库，请确认数据库名称正确！");
        $this->execute("SET NAMES UTF8");
    }

    /*
     * 执行sqlyuju,返回数组
     * getArray
     */
    public function getDbData($sql)
    {
        if (!$result = $this->execute($sql)) return array();
        if (!mysql_num_rows($result)) return array();
        $rows = array();
        while ($rows[] = mysql_fetch_array($result, MYSQL_ASSOC)) {
        }
        mysql_free_result($result);
        array_pop($rows);
        return $rows;
    }

    /**
     * 获取当前表主键
     * newinsertid
     */
    public function getPK()
    {
        return mysql_insert_id($this->conn);
    }

    /**
     * 格式化带limit的SQL语句
     * setlimit
     */
    public function formatLimit($sql, $limit)
    {
        return $sql . " LIMIT {$limit}";
    }

    /**
     * 执行一个SQL语句
     * exec
     */
    public function execute($sql)
    {
        $this->arrSql[] = $sql;
        if ($result = mysql_query($sql, $this->conn)) {
            return $result;
        } else {
            _show_error("{$sql}<br />执行错误: " . mysql_error());
        }
    }

    /**
     * 返回影响行数
     */
    public function affected_rows()
    {
        return mysql_affected_rows($this->conn);
    }

    /**
     * 获取数据表结构
     * getTableStruct
     */
    public function getTableStruct($table_name)
    {
        return $this->getArray("DESCRIBE {$table_name}");
    }


    /**
     * 对特殊字符进行过滤
     * __val_escape
     */
    public function db_filter($val)
    {
        if (is_null($val)) return 'NULL';
        if (is_bool($val)) return $val ? 1 : 0;
        if (is_int($val)) return (int)$val;
        if (is_float($val)) return (float)$val;
        if (@get_magic_quotes_gpc()) $val = stripslashes($val);
        return '\'' . mysql_real_escape_string($val, $this->conn) . '\'';
    }


    /*
     * 记录sql语句
     */
    public function record_sql($sql)
    {

    }

    /*
     * 记录报错
     */
    public function record_error()
    {

    }

    public function free()
    {
        mysql_close($this->conn);
    }
}

