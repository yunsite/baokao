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
         $this->assign('bk_list', $Bk_num->order('stu_join desc')->select());
         $this->display();
     }

     /**
      * 报考次数修改
      */
     public function  edit_bknum(){
         $bk_id=addslashes($_GET['id']);
         //判断是否传递合法的id,必须为数值型
         if(!is_numeric($bk_id)){
             $this->redirect('config/set_bknum');
             exit();
         }

         $Bk_num=M('Bk_num');
         $this->assign($Bk_num->where("bk_id={$bk_id}")->find());

         $this->display();
     }

     /**
      * 对修改的报考次数进行保存
      */
     function save_bknum(){
         $bk_num=addslashes($_POST['bk_num']);
         $bk_id=addslashes($_POST['bk_id']);
         //检测传递的$bk_id是否符合系统要求，必须为数值
         if(!is_numeric($bk_id)){
             $this->ajaxReturn(0);
             exit ();
         }
         //检测传递的$bk_num是否符合系统要求，必须为数值
         if(!is_numeric($bk_num)){
             $this->ajaxReturn(1);
             exit ();
         }

         //开始进行修改
         $Bk_num=M('Bk_num');
         if($Bk_num->where("bk_id={$bk_id}")->setField('bk_num',$bk_num)){
             $this->ajaxReturn(3);  //保存成功
         }else{
             $this->ajaxReturn(2);  //无修改
         }
     }

     /**
      * 保存增加的新报考次数项
      */
     function save_add_bknum(){
         $bk_num=addslashes($_POST['bk_num']);
         $stu_join=addslashes($_POST['stu_join']);
         //检测传递的$bk_num是否符合系统要求，必须为数值
         if(!is_numeric($bk_num)){
             $this->ajaxReturn(0);
             exit ();
         }

         $Bk=M('Bk_num');
         if($Bk->where("stu_join='{$stu_join}'")->count()>0){
             $this->ajaxReturn(1);
             exit();
         }

         $data['bk_num']=$bk_num;
         $data['stu_join']=$stu_join;
         if($Bk->add($data)){
             $this->ajaxReturn(2);
             
         }


     }
    
}
?>
