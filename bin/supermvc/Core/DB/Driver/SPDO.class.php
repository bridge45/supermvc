<?php

/**
 * PDO 数据库的驱动
 */
class SPDO
{

    /**
     * 数据库链接句柄
     */
    public $conn;

    /**
     * 构造函数
     */
    public function __construct($db_con)
    {
        $this->conn = new PDO($db_con['driver'].':host='.$db_con['host'].';dbname='.$db_con['database'].';charset=utf8',$db_con['user'],$db_con['pwd']);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//默认还是一次传送,false改为粉刺传送
    }


    /**
     * 格式化带limit的SQL语句
     * setlimit(不同的数据库应该不一样)
     */
    public function formatLimit($sql, $limit)
    {
        //TODO 不同的数据库不一样的处理方式
        return $sql . " LIMIT {$limit}";
    }

    /**
     * 执行一个SQL语句
     * $bindParm 占位符参数
     * $mode 1:返回数组数据,2返回影响行数
     */
    public function execute($sql,$bindValue,$mode = 1)
    {
            $st = $this->conn->prepare($sql);
            if (!empty($bindValue)) {
                foreach ($bindValue as $key => $val) {
                    $st->bindValue($key + 1, $val);
                }
            }
            echo 'RES = ' . $st->execute();
            return $mode == 1 ? $st->fetchAll() : $st->rowCount();
    }

    /*
     * 开始事务
     */
    public function beginTrance(){
        /* 开始一个事务，关闭自动提交 */
        $this->conn->beginTransaction();
    }

    public function lock($lock_table_excute_code){
        $this->conn->exec('lock tables '.$lock_table_excute_code);
    }

    public function commit(){
        $this->conn->commit();
    }

    public function rollBack(){
        $this->conn->rollBack();
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
        //mysql_close($this->conn);
    }
}
