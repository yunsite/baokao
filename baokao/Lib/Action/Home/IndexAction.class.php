<?php
// 首页
class IndexAction extends Action{
    /**
     +--------------------------------------------------------------------------
     * 说明：报考系统学生端首页
     +--------------------------------------------------------------------------
     * 作者：窦子滨
     +--------------------------------------------------------------------------
     * www.cn-024.cn
     +--------------------------------------------------------------------------
     */
    public function index(){
        //判断是否缓存了科目名称
        if(!S('kemu_name')){
            $Config=M('Config');
            S('kemu_name',$Config->getField('kemu_name'),-1);
        }

        $this->assign('kemu_name', S('kemu_name'));
        $this->display();
    }




    //对报考信息进行检测，并进行报考信息的保存
    function check_info(){
        //判断是否为ajax请求
        if(!$this->isAjax()){
            echo 'Access Error!<br />';//输出错误信息
            echo 'QQ:83429645';
            exit();
        }
        //获取传递的验证码，并md5加密
        $yz_num=md5($_POST['yz_num']);
        //检测验证码是否正确
         if($yz_num!=$_SESSION['verify']){
            $_SESSION['verify']=md5('lfy42342344');
            $this->ajaxReturn(0);    //验证码错误
            exit();
        }
        //设置全局的缓存时间  -1为永久缓存
        $cache_time=-1;

        //获取用户的学号$stu_no
        //获取用户的姓名$stu_name
        $stu_no=addslashes($_POST['stu_no']);
        $stu_name=addslashes($_POST['stu_name']);
        //检测缓存是否存在
        if(!S('stu'.$stu_no)){    //不存在则执行
            $Stu_info=M('Stu_info');
            if($Stu_info->where("stu_no='{$stu_no}'")->count()>0){
                //永久缓存学生的信息  stu+学号 
                S('stu'.$stu_no,$Stu_info->where("stu_no='{$stu_no}'")->find(),$cache_time);
            }else{
                $_SESSION['verify']=md5('lfy42342344');
                $this->ajaxReturn(1);//该学生不存在
                exit();
            }
        }

        //学生信息数组  $stu_info
        $stu_info=S('stu'.$stu_no);  //从缓存中读取特定学号学生的信息

        if($stu_name!=$stu_info['stu_name']){
            $_SESSION['verify']=md5('lfy546456yhty');
            $this->ajaxReturn(2);   //该学生姓名不正确
            exit();
        }

        //检测是否存在合格缓存
        if(!S('hg'.$stu_no)){
            $Stu_hege=M('Stu_hege');
            if($Stu_hege->where("stu_no='{$stu_no}'")->count()>0){
                //永久缓存合格数据
                S('hg'.$stu_no,$Stu_hege->where("stu_no='{$stu_no}'")->find(),$cache_time);
                $_SESSION['verify']=md5('lfy546456yhty');
                $this->ajaxReturn(3);   //该学生已经合格
                exit();
            }
        }else{   //缓存了则直接视为合格
            $_SESSION['verify']=md5('lfy546456yhty');
            $this->ajaxReturn(3);   //该学生已经合格
            exit();
        }


        //检测是否存在该学生的违纪缓存
        if(!S('wj'.$stu_no)){
            $Stu_weiji=M('Stu_weiji');
            if($Stu_weiji->where("stu_no='{$stu_no}'")->count()>0){
                //永久缓存学生违纪数据
                S('wj'.$stu_no,$Stu_weiji->where("stu_no='{$stu_no}'")->find('off'),$cache_time);
            }
        }
        
        //如果存在缓存，则检测是否允许在次报考
        if(S('wj'.$stu_no)){
            $weiji_info=S('wj'.$stu_info);  //读取是否运行报考
            //检测标记是否允许再次报考
            if($weiji_info['off']=='f'){
                $_SESSION['verify']=md5('lfy546456yhty');
                $this->ajaxReturn(4);   //该学生违纪，无法再次报考
                exit();
            }
        }

        //检测是否存在该学生入学年级的批次信息缓存信息
        if(!S('pc'.$stu_info['stu_join'])){
            $Pici=M('Pici');
            S('pc'.$stu_info['stu_join'],$Pici->where("pc_join='{$stu_info['stu_join']}'")->find(),3600);
        }

        //从缓存中读取该学生所在入学年级的批次信息
        $pc_info=S('pc'.$stu_info['stu_join']);

        //判断是否存在报考
        if($pc_info['pc_off']!='t'){
            $_SESSION['verify']=md5('lfy5fdfd456yhty');
            $this->ajaxReturn(5);   //报考信息不存在或者报考尚未开始
            exit();
        }



        

        //检测是否存在该学生所在年级每人限制报考的次数  不存在
        if(!S('bk'.$stu_info['stu_join'])){
            $Bk=M('Bk_num');
            //缓存年级每人的报考次数
            S('bk'.$stu_info['stu_join'],$Bk->where("stu_join='{$stu_info['stu_join']}'")->getfield('bk_num'),$cache_time);
        }

        //从缓存读取每人限制的报考次数
        $bk_num=S('bk'.$stu_info['stu_join']);
            
                
        $Stubk_temp=M('Stubk_temp');
        //检测该学生是否已经报考了
        if($Stubk_temp->where("stu_no='{$stu_no}' and pc_id={$pc_info['pc_id']}")->count()>0){
            $_SESSION['verify']=md5('lfy546456yhty');
            $this->ajaxReturn(6);   //该学生已经报考
        }elseif($Stubk_temp->where("pc_id={$pc_info['pc_id']}")->count()>=$pc_info['pc_num']){
            //已经达到该批次限定人数
            $_SESSION['verify']=md5('lfy546456yhty');
            $this->ajaxReturn(7);   //已经达到该批次限定人数
        }elseif($Stubk_temp->where("stu_no='{$stu_no}'")->count()>=$bk_num){
            //全部报考次数已经用尽
            $_SESSION['verify']=md5('lfy546456yhty');
            $this->ajaxReturn(8);   //全部报考次数已经用尽
        }else{
            //写入报考信息
            $data['stu_no']=$stu_no;
            $data['pc_id']=$pc_info['pc_id'];
            $data['sb_input_time']=time();
            Load('extend');
            $data['sb_input_ip']=get_client_ip();
            $Stubk_temp->add($data);

            //保存session信息
            Session::set('lfy_stuno',$stu_no);
            //保存登录标记  md5(学号+姓名)
            Session::set('lfy_kkk',md5($stu_no.'lfy19881214'));
            $_SESSION['verify']=md5('lfy546456dyhty');
            $this->ajaxReturn(10);   //报考成功
        }
    }


    //进行学生信息的查询
    function chaxun(){
        //判断是否为ajax请求
        if(!$this->isAjax()){
            echo 'Access Error!<br />';//输出错误信息
            echo 'QQ:83429645';
            exit();
        }
        //获取传递的验证码，并md5加密
        $yz_num=md5($_POST['yz_num']);
        //检测验证码是否正确
         if($yz_num!=$_SESSION['verify']){
            $_SESSION['verify']=md5('lfy42342344');
            $this->ajaxReturn(0);    //验证码错误
            exit();
        }
        //设置全局的缓存时间  -1为永久缓存
        $cache_time=-1;

        //获取用户的学号$stu_no
        //获取用户的姓名$stu_name
        $stu_no=addslashes($_POST['stu_no']);
        $stu_name=addslashes($_POST['stu_name']);
        //检测缓存是否存在
        if(!S('stu'.$stu_no)){    //不存在则执行
            $Stu_info=M('Stu_info');
            if($Stu_info->where("stu_no='{$stu_no}'")->count()>0){
                //永久缓存学生的信息  stu+学号
                S('stu'.$stu_no,$Stu_info->where("stu_no='{$stu_no}'")->find(),$cache_time);
            }else{
                $_SESSION['verify']=md5('lfy42342344');
                $this->ajaxReturn(1);//该学生不存在
                exit();
            }
        }

        //学生信息数组  $stu_info
        $stu_info=S('stu'.$stu_no);  //从缓存中读取特定学号学生的信息

        if($stu_name!=$stu_info['stu_name']){
            $_SESSION['verify']=md5('lfy546456yhty');
            $this->ajaxReturn(2);   //该学生姓名不正确
            exit();
        }


        //以下为查询成功后进行的后续处理操作
        //保存session信息
            Session::set('lfy_stuno',$stu_no);
            //保存登录标记  md5(学号+姓名)
            Session::set('lfy_kkk',md5($stu_no.'lfy19881214'));
        $_SESSION['verify']=md5('lfy546456yhty');
        $this->ajaxReturn(11);  //查询成功进行跳转显示查询结果
    }


    //显示查询的结果
    function jieguo(){
        //设置全局的缓存时间  -1为永久缓存
        $cache_time=-1;
        if(!Session::is_set('lfy_stuno') or $_SESSION['lfy_kkk']!=md5($_SESSION['lfy_stuno'].'lfy19881214')){
            $this->redirect('index/index');
            exit();
        }

        if(!S('kemu_name')){
            $Config=M('Config');
            S('kemu_name',$Config->getField('kemu_name'),$cache_time);
        }
        //箱模板赋值科目名称
        $this->assign('kemu_name', S('kemu_name'));
        //读取学号信息
        $stu_no=addslashes($_SESSION['lfy_stuno']);

        if(!S('stu'.$stu_no)){
            $Stu_info=M('Stu_info');
            S('stu'.$stu_no,$Stu_info->where("stu_no='{$stu_no}'")->find(),$cache_time);
        }
        $this->assign(S('stu'.$stu_no));

        $stu_list=S('stu'.$stu_no);
        if(!S('bk'.$stu_list['stu_join'])){
            $Bk=M('Bk_num');
            //永久缓存年级每人的报考次数
            S('bk'.$stu_list['stu_join'],$Bk->where("stu_join='{$stu_list['stu_join']}'")->getfield('bk_num'),$cache_time);
        }

        $Stubk_temp=M('Stubk_temp');
        //计算已经报考的次数
        $ready_num=$Stubk_temp->where("stu_no='{$stu_no}'")->count();
        //向模板赋值剩余的考试次数
        $this->assign('sy_num',S('bk'.$stu_list['stu_join'])-$ready_num);
        //
        $this->assign('bk_num', S('bk'.$stu_list['stu_join']));

        //获取学生的全部报考信息
        $bk_list=$Stubk_temp->table("lfy_stubk_temp,lfy_pici")->where("lfy_pici.pc_id=lfy_stubk_temp.pc_id and stu_no='{$stu_no}'")->order('sb_input_time desc')->select();
        $Date=D('Date');
        //将秒时间转换为日期时间制
        $bk_list=$Date->array_timetodate($bk_list);

        $this->assign('bk_list', $bk_list);


        //获取学生的全部合格信息
        $Stu_hege=M('Stu_hege');
        $hg_list=$Stu_hege->table("lfy_pici,lfy_stu_hege")->where("lfy_pici.pc_id=lfy_stu_hege.pc_id and stu_no='{$stu_no}'")->select();
        $this->assign('hg_list', $hg_list);

        //获取学生的全部合格信息
        $Stu_weiji=M('Stu_weiji');
        $wj_list=$Stu_weiji->table("lfy_pici,lfy_stu_weiji")->where("lfy_pici.pc_id=lfy_stu_weiji.pc_id and stu_no='{$stu_no}'")->select();
        $this->assign('wj_list', $wj_list);
        
            


        $this->display();
    }




    

    /**
     * 显示报考成功信息
     */
    function ok(){
        if(!Session::is_set('lfy_stuno') or $_SESSION['lfy_kkk']!=md5($_SESSION['lfy_stuno'].'lfy19881214')){
            $this->redirect('index/index');
        }else{
            //判断是否缓存了科目名称
            if(!S('kemu_name')){
                $Config=M('Config');
                S('kemu_name',$Config->getField('kemu_name'),-1);
            }
            $this->assign('kemu_name', S('kemu_name'));

            $stu_no=addslashes($_SESSION['lfy_stuno']);
            if(!S('stu'.$stu_no)){
                $Stu_info=M('Stu_info');
                S('stu'.$stu_no,$Stu_info->where("stu_no='{$stu_no}'")->find(),-1);
            }
            $this->assign(S('stu'.$stu_no));

            $stu_list=S('stu'.$stu_no);
            if(!S('bk'.$stu_list['stu_join'])){
                $Bk=M('Bk_num');
                //永久缓存年级每人的报考次数
                S('bk'.$stu_list['stu_join'],$Bk->where("stu_join='{$stu_list['stu_join']}'")->getfield('bk_num'),-1);
            }

            $Stubk_temp=M('Stubk_temp');
            $ready_num=$Stubk_temp->where("stu_no='{$stu_no}'")->count();
            $this->assign('sy_num',S('bk'.$stu_list['stu_join'])-$ready_num);

            $this->assign('bk_num', S('bk'.$stu_list['stu_join']));

            //检测批次信息是否被缓存
            if(!S('pc'.$stu_list['stu_join'])){
                $Pici=M('Pici');
                S('pc'.$stu_list['stu_join'],$Pici->where("pc_join='{$stu_list['stu_join']}' and pc_off='t'")->find(),3600);
            }

            $this->assign(S('pc'.$stu_list['stu_join']));

            $this->display();
        }
    }
}

?>