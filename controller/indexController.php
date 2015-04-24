<?php

class index extends controller{



    public function start(){
        $data = $this->table('user')->add(array('name'=>'爱乐q','content'=>'爱乐信息q'));
        echo json_encode($data);
        $data = $this->table('user')->
        where('id = ? and name = ?',array(9,'爱乐T'))->
        save(array('name'=>'爱乐T','content'=>'爱乐信息T'));
        echo json_encode($data);
        $data = $this->table('user')->count();
        echo json_encode($data);
        $data = $this->exec('select count(*) from user',1,array());
        echo json_encode($data);die;
        $this->assign('name','SDCSCAS');
        $this->display(APP_PATH.'/template/home/index.tpl');
    }

    public function ok(){
        echo 'OK';
    }
}