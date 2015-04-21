<?php

class index extends controller{



    public function start(){
        $data = $this->db->table('user')->select();
        echo json_encode($data);die;
        $this->assign('name','SDCSCAS');
        $this->display(APP_PATH.'/template/home/index.tpl');
    }

    public function ok(){
        echo 'OK';
    }
}