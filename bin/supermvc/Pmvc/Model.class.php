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

    protected $bindValue = array();

    public function __construct(){
        require LP_MC_DB.'/Driver/SPDO.class.php';
        $this->_db = new SPDO(C('db'));
    }

    //////////////////////////////CURD PART/////////////////////////////////////////
    /*
     * Query a record
     */
    public function find(){
        $data = $this->limit(1)->select();
        return isset($data[0]) ? $data[0] : false;
    }

    /*
     * Query a records
     */
    public function select(){
        $this->checkTable();
        $sql = 'SELECT '.$this->field.' FROM '.$this->table;
        if($this->where)
            $sql .= ' '.$this->where;
        if($this->order)
            $sql .= ' '.$this->order;
        if($this->limit)
            $sql = $this->_db->formatLimit($sql,$this->limit);
        return $this->_db->execute($sql,$this->bindValue);
    }


    /*
     * Delete a record
     */
    public function delete(){
        $this->checkTable();
        $sql = 'DELETE  FROM '.$this->table;
        if($this->where)
            $sql .= ' '.$this->where;
        return $this->_db->execute($sql,$this->bindValue,2);
    }

    /*
     * Insert a record
     */
    public function add($data){
        $this->checkTable();
        if(empty($data))
            _show_error('必须输入插入的数组');
        foreach($data as $key=>$val){
            $fields[] = '`'.$key.'`';
            $vals[]   = '?';
            $this->bindValue[]   = $val;
        }
        $sql = 'insert into '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',', $vals).')';
        return $this->_db->execute($sql,$this->bindValue,2);
    }

    /*
     * 保存修改
     */
    public function save($data,$ext = ''){
        $this->checkTable();
        if(!$this->where) _show_error('安全起见,更新操作必须有where条件呀!');
        $newBindValue = array();
        if(!$data) _show_error('必须输入修改参数啊!');
        foreach($data as $key=>$val){
            $Sets[] = '`'.$key.'` = '.' ? ';
            $newBindValue[]   = $val;
        }
        $this->bindValue = array_merge($newBindValue,$this->bindValue);
        $sql = 'UPDATE '.$this->table .' SET '.implode(',',$Sets);
        $sql .= ' '.$this->where;
        return $this->_db->execute($sql,$this->bindValue,2);
    }

    /*
     * 统计数据量
     */
    public function count(){
        $this->checkTable();
        $this->field = 'count(*)';
        $sql = 'select '.$this->field.' from '.$this->table;
        if($this->where)
            $sql .= ' '.$this->where;
        if($this->limit)
            $sql = $this->_db->formatLimit($sql,$this->limit);
        $res = $this->_db->execute($sql,$this->bindValue);
        return isset($res['0']['0']) ? $res['0']['0'] : '';
    }

    protected function checkTable(){
        if(!$this->table)
            _show_error('table must be set!');
    }

    /*
     * 自己执行sql
     */
    public function exec($sql,$bindValue = false){
        if(false === $bindValue)
            _show_error('bindValue 必须传参数咯[如果没有外部参数],传入array()吧!');
        $res = $this->_db->execute($sql,$bindValue);
        return isset($res['0']['0']) ? $res['0']['0'] : '';
    }

    //////////////////////////////CURD部分/////////////////////////////////////////

    /////////////////////////////////对象配置部分/////////////////////////////////////////////
    /*
     * 设置操作表
     */
    public function table($table_name){
        $this->bindValue = array();
        $this->table = C('db.prefix').$table_name;
        return $this;
    }

    /*
     * 设置where
     */
    public function where($where,$bindValue){
        if(!strpos($where, '?'))
                    _show_error('where必须用占位符模式');
        if(substr_count($where, '?') != count($bindValue))
            _show_error('传参个数和占位符个数不等');
        $this->bindValue = array_merge($this->bindValue,$bindValue);
        $this->where = ' where '.$where;
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

    public function  join(){
        //ToDo 加入join功能
    }

    /*
     * 开启事务
     * $lock_table_excute_code t_user write,t_orders read
     */
    public function beginTrance(){
        $this->_db->beginTrance();
        return $this->_db;
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

    /*
     * 释放数据库连接
     */
    public function free(){
        $this->_db->free();
    }
}