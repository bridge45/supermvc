<?php

/**
 * 缓存管理类
 */
class Cache
{

    protected $mem_object;

    protected $options;
    protected $handler;

    public function __construct()
    {
            $this->options = $c = C('cache');
            $this->handler = new Memcache();
            if(!$this->handler->connect($c['host'], $c['port']))
                Error('memcache 无法连接![可能是服务未启动...]');
    }

    /*
     * 获取对象实例
     */
    static function getInstance()
    {
        static $instances = '';
        if(!$instances)
            return new Cache;
        else
            return $instances;
    }

    function  hash($key){
        return $this->options['hash'] ? md5($this->options['prefix'].'_'.$key) : $key;
    }

    /**
     * 读取缓存
     * @access public
     * @param string $key 缓存变量名
     * @return mixed
     */
    public function get($key) {
        return $this->handler->get($this->hash($key));
    }

    /**
     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param integer $expire  有效时间（秒）
     * @return boolean
     */
    public function set($key, $value, $expire = null) {
        $key = $this->hash($key);
        if(is_null($expire)) {
            $expire  =  $this->options['expire'];
        }
        if($this->handler->set($key, $value, 0, $expire)) {
            return true;
        }
        return false;
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($key) {
        $this->handler->delete($this->hash($key));
    }

    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function clear() {
        return $this->handler->flush();
    }

}