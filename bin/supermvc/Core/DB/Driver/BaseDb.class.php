<?php
/*
 * 添加数据库底层接口
 */
interface DB{

    /**
     * 构造函数
     */
    public function __construct($db_con);

    /*
     * 执行sqlyuju,返回数组
     * getArray
     */
    public function getDbData($sql,$bindPargm = array());

    /**
     * 获取当前表主键
     * newinsertid
     */
    public function getPK();

    /**
     * 格式化带limit的SQL语句
     * setlimit
     */
    public function formatLimit($sql, $limit);

    /**
     * 执行一个SQL语句
     * exec
     */
    public function execute($sql);

    /**
     * 返回影响行数
     */
    public function affected_rows();

    /**
     * 获取数据表结构
     * getTableStruct
     */
    public function getTableStruct($table_name);


    /**
     * 对特殊字符进行过滤
     * __val_escape
     */
    public function db_filter($val);


    /*
     * 记录sql语句
     */
    public function record_sql($sql);

    /*
     * 记录报错
     */
    public function record_error();

    /*
     * 是否资源
     */
    public function free();


}