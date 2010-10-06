<?php
class MainAction extends Action{
    function _initialize()  //初始化
    {
         $R=D('Admin.Login');
         $R->check_admin();
    }
    function index(){
        $this->display();
    }
}
?>
