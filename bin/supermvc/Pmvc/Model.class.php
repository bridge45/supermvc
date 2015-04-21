<?php

class Model{


    /**
     * 数据驱动程序
     */
    protected $_db;

    /*
     * 返回字段
     */
    protected $field = '*';

    /*
     * 表名称
     */
    protected $table = '';

    /*
     * where 条件
     */
    protected $where;

    /*
     * limit 条件
     */
    public $limit;

    /*
     * order
     */
    public $order;

    public function __construct(){
        require LP_MC_DB.'/Driver/BaseDb.class.php';
        require LP_MC_DB.'/Driver/Mysql.class.php';
        $this->_db = new Mysql(C('db'));
    }

    //////////////////////////////CURD部分/////////////////////////////////////////
    /*
     * 查询一条记录出来
     */
    public function find(){
        $this->limit(1);
        $data = $this->select();
        return isset($data[0]) ? $data[0] : false;
    }

    /*
     * 查询多条
     */
    public function select(){
        if(!$this->table)
            _show_error('table must be set!');
        $sql = 'select '.$this->field.' from '.$this->table;
        if($this->where)
            $sql .= ' '.$this->where;
        if($this->limit)
            $sql = $this->_db->formatLimit($sql,$this->limit);
        if($this->order)
            $sql .= ' '.$this->order;
        return $this->exec($sql);
    }

    /*
     * 删除一条
     */
    public function delete(){

    }

    /*
     * 插入一条
     */
    public function add(){

    }

    /*
     * 保存修改
     */
    public function save(){

    }

    /*
     * 统计数据量
     */
    public function count(){

    }

    /*
     * 自己执行sql
     */
    public function exec($sql){
        return $this->_db->getDbData($sql);
    }

    //////////////////////////////CURD部分/////////////////////////////////////////

    /////////////////////////////////对象配置部分/////////////////////////////////////////////
    /*
     * 设置操作表
     */
    public function table($table_name){
        $this->table = $table_name;
        return $this;
    }

    /*
     * 设置where
     */
    public function where($where){
        $this->where = $where;
        return $this;
    }

    /*
     * field 设置
     */

    public function field($field){
        $this->field = $field;
        return $this;
    }

    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }

    public function order($order){
        $this->order = $order;
        return $this;
    }

    /////////////////////////////////对象配置部分/////////////////////////////////////////////


    /*
     * 获取刚刚执行的sql语句
     */
    public function getLastSql(){

    }

    /*
     * 获取本次所有sql
     */
    public function getAllSql(){

    }



}