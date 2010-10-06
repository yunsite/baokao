<?php
//系统管理控制器类


class SystemAction extends Action{
	
	public function out()   //退出系统
	{
                $_SESSION['lfy_name']='';
                $_SESSION['lfy']='';
                //清空session数据
		Session::clear();
                //销毁session变量
		Session::destroy();
                $this->redirect('index/index');
	}


        Public function check()
        {
                if($this->isAjax()){
                    $admin_name=addslashes($_POST['admin_name']);
                    $admin_pwd=md5($_POST['admin_pwd']);
                    $Lanfengye=M('Lanfengye');

                    if($Lanfengye->where("user_name='{$admin_name}'")->count()<=0){
                        echo '<font color="red">该用户不存在！</font>';
                    }else if($Lanfengye->where("user_name='{$admin_name}' and user_pwd='{$admin_pwd}'")->count()<=0){
                        echo '<font color="red">密码不正确！</font>';
                    }else{
                        Session::set('lfy_name',$admin_name);
                        Session::set('lfy',md5('lfy000'));
                        $str=U("main/index");
                                echo '<script type="text/javascript">'
                                    ."location.href='{$str}';"
                                    .'</script>';
                    }

                }
        }
}
?>