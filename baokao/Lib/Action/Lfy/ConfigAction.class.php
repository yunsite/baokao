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
             //获取修改成功的报考次数项的入学年级
            $stu_join=$Bk_num->where("bk_id={$bk_id}")->getField('stu_join');
            //清理该入学年级的缓存信息
            S("bk{$stu_join}",null);

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

     /**
      * 设置报考批次设置页面
      */
     function set_pici(){
        $Pici=M('Pici');
        $this->assign('pc_list', $Pici->order('pc_id desc')->select());

         $this->display();
     }

     /**
      * 将传递的pc_id指定的批次状态置为开启
      */
     function set_pckaiqi(){
         $pc_id=addslashes($_POST['pc_id']);
         //检测pc_id是否为数值型
         if(!is_numeric($pc_id)){
             $this->ajaxReturn(0);
             exit();
         }
         $Pc=M('Pici');
         $pc_join=$Pc->where("pc_id={$pc_id}")->getField('pc_join');
         if($Pc->where("pc_join='{$pc_join}' and pc_off='t'")->count()>0){
             $this->ajaxReturn(8);   //已经存在开启的
             exit();
         }


         if($Pc->where("pc_id={$pc_id}")->setField('pc_off','t')){
             S("pc{$pc_join}",null);  //清除该批次的缓存信息
             $this->ajaxReturn(2);   //设置状态成功
         }else{
             $this->ajaxReturn(1);   //设置状态失败
         }

     }



     /**
      * 将传递的pc_id指定的批次状态置为禁用
      */
     function set_pcjinyong(){
         $pc_id=addslashes($_POST['pc_id']);
         //检测pc_id是否为数值型
         if(!is_numeric($pc_id)){
             $this->ajaxReturn(0);
             exit();
         }
         $Pc=M('Pici');
         if($Pc->where("pc_id={$pc_id}")->setField('pc_off','f')){
             $this->ajaxReturn(2);   //设置状态成功
         }else{
             $this->ajaxReturn(1);   //设置状态失败
         }

     }

     /**
      * 保存新增加的批次信息
      */
     function save_add_pici(){
         $data['pc_name']=addslashes($_POST['pc_name']);
         $data['pc_join']=addslashes($_POST['pc_join']);
         $data['pc_num']=addslashes($_POST['pc_num']);
         $data['pc_time']=addslashes($_POST['pc_time']);
         $data['pc_address']=addslashes($_POST['pc_address']);
         $data['pc_beizhu']=addslashes($_POST['pc_beizhu']);
         if($data['pc_name']=='' || $data['pc_join']=='' || $data['pc_time']==''){
             $this->ajaxReturn(0);    //有一项或几项为空
             exit();
         }
         if(!is_numeric($data['pc_num'])){
             //判断限制人数是否为数值型
             $this->ajaxReturn(1);
             exit();
         }

         $Pc=M('Pici');
         if($Pc->add($data)){
             //添加成功
             $this->ajaxReturn(2);
         }else{
             //添加失败
             $this->ajaxReturn(3);
         }
     }
    
}
?>
