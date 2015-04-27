<?php

class index extends controller{

    public function __construct(){
        parent::__construct();
    }


    public function start(){
        cookie(null);
        echo '<pre>';
        print_r($_COOKIE);
    }

    public function index(){
        echo  cookie();

    }



    public function start0(){
        //        $data = $this->table('user')->add(array('name'=>'爱乐A','content'=>'爱乐信息'));
        //         $this->startTrance('user write');
        //        $data = $this->table('user')->add(array('name'=>'爱乐B','content'=>'爱乐信息'));
        //        $this->commit();
//        $be = $this->beginTrance();
//        $be->lock('`user` write');
//        $data = $this->table('user')->add(array('name'=>'爱乐C','content'=>'爱乐信息'));
//        $this->rollBack();
//
//        $data = $this->table('user')->add(array('name'=>'爱乐D','content'=>'爱乐信息'));
//
//
//        echo json_encode($data);
//        $data = $this->table('user')->add(array('name'=>'爱乐q','content'=>'爱乐信息q'));
//        echo json_encode($data);
//        $data = $this->table('user')->
//        where('id = ? and name = ?',array(9,'爱乐T'))->
//        save(array('name'=>'爱乐T','content'=>'爱乐信息T'));
//        echo json_encode($data);
//        $data = $this->table('user')->count();
//        echo json_encode($data);
//        $data = $this->exec('select count(*) from user',1,array());
//        echo json_encode($data);die;
//        $this->assign('name','SDCSCAS');
//        $this->display(APP_PATH.'/template/home/index.tpl');
    }

    public function ok(){
        echo 'OK';
    }
}