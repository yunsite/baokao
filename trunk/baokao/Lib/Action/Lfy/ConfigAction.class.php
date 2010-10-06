<?php
/**
 * 系统配置类
 *
 * @author lanfengye2008
 */
class ConfigAction extends Action{
    function _initialize()  //初始化
    {
         $Login=D('Admin.Login');
         $Login->check_admin();
    }
    /**
     * 科目名称设置页面
     */
    function set_kmname(){

        //判断是否缓存了科目名称
        if(!S('kemu_name')){
            $Config=M('Config');
            S('kemu_name',$Config->getField('kemu_name'),-1);
        }

        $this->assign('km_name',S('kemu_name'));
        
        $this->display();
    }


    /**
     * 科目名称的保存
     */
     function save_kmname(){
         if(!$this->isAjax()){
            echo 'Access Error!<br />';//输出错误信息
            echo 'QQ:83429645';
            exit();
         }

         $km_name=addslashes($_POST['km_name']);

         if(empty ($km_name)){
             //科目名称为空
             $this->ajaxReturn(0);
             exit ();
         }

         $Config=M('Config');
         if($Config->setField('kemu_name',$km_name)){
             S('kemu_name',null);
             $this->ajaxReturn(1); //设置成功
         }else{
             $this->ajaxReturn(2);  //未改变
         }
     }

     /**
      * 各年级报考次数设置页面
      */
     public function set_bknum(){
         $Bk_num=M('Bk_num');
         $this->assign('bk_list', $Bk_num->order('stu_join')->select());
         $this->display();
     }
    
}
?>
