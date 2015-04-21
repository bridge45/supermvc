<?php

class index extends controller{



    public function start(){
        $this->assign('name','452353425345');
        $this->display(APP_PATH.'/template/home/index.tpl');
    }

    public function ok(){
        echo 'OK';
    }
}