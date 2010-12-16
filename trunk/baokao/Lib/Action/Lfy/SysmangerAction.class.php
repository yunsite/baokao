<?php
//系统管理控制器
class SysmangerAction extends Action{
    function _initialize()  //初始化
    {
         $Login=D('Admin.Login');
         $Login->check_admin();
    }
    
    //进行管理员的管理
    function admin(){
        $Login=D('Admin.Login');
        $Login->check_admin();
        $Admin=D('Admin.Admin');
        $this->assign('list', $Admin->get_admin());
        $this->display();
    }
    
    function save_edit_pwd()   //保存管理员修改自身的密码
    {
        if($this->isAjax()){
            $old_pwd=md5($_POST['old_pwd']);
            $new_pwd=md5($_POST['new_pwd']);
            $Admin=D('Admin.Admin');
            $Lanfengye=M('Lanfengye');
            if($Lanfengye->where("user_name='{$_SESSION['lfy_name']}' and user_pwd='{$old_pwd}'")->count()>0){
                if($Lanfengye->where("user_name='{$_SESSION['lfy_name']}'")->setField('user_pwd', $new_pwd)){
                    echo '<font color="red">新密码修改成功！请牢记您的新密码！</font>';
                }
                else
                {
                    echo '<font color="red">数据错误！请重新进行密码修改操作！</font>';
                }
            }
            else
                {
                echo '<font color="red">原始密码不正确！请重新修改密码！再次点击功能菜单的修改密码即可！</font>';
            }
        }
        else
            {
            echo '<font color="red">数据请求错误！请刷新网页后重新修改密码！</font>';
        }
    }


    /*检测用户名是否存在*/
    function check_admin_name(){
        if($this->isAjax()){
            $admin_name=addslashes($_POST['admin_name']);
            $Lan=M('Lanfengye');
            if($Lan->where("user_name='{$admin_name}'")->count()>0){
                $this->ajaxReturn(1, 'user ready have', 1);
            }
            else
                {
                $this->ajaxReturn(2, 'not user', 2);
            }
        }
        else
            {
            echo '<font color="red">请求错误！请正确进行数据提交！</font>';
        }

    }


    function save_add_admin(){
        if($this->isAjax()){
            $admin_name=addslashes($_POST['admin_name']);
            $admin_pwd=md5($_POST['admin_pwd']);
            if($admin_name==''){
                $this->ajaxReturn(0);   //用户名不能为空
            }else{
                $Admin=M('Lanfengye');
                $data['user_name']=$admin_name;
                $data['user_pwd']=$admin_pwd;
                if($Admin->where("user_name='{$admin_name}'")->count()>0){
                    $this->ajaxReturn(1);  //管理员用户已经存在
                }else{
                    $id=$Admin->add($data);
//                    if($id){
                    $this->ajaxReturn(2, $id);   //管理员用户添加成功,并返回新管理员用户的id
//                    }
//                    else{
//                        $this->ajaxReturn(999);
//                    }
                }
            }
        }else{
            $this->ajaxReturn(1111);
        }
    }

    //删除管理员
    function del_admin(){
        if($this->isAjax()){
            $admin_id=addslashes($_POST['admin_id']);
            $Lan=M('Lanfengye');
            if($Lan->count()<=1){
                $this->ajaxReturn(1);  //必须保留一个管理用户！ return 1
            }else{
                $Lan->delete($admin_id);  //删除主键为admin_id的数据
                $this->ajaxReturn(2);  //删除成功 return 2
            }
        }else{
            $this->ajaxReturn(999);  //系统错误  return other
        }
    }



    /**
     * 获取管理员列表，返回json编码的数据
     */
    function get_list(){
        if($this->isAjax()){
            $Lan=M('Lanfengye');
            $str=json_encode($Lan->field('user_id,user_name')->select());
            echo $str;
        }else{
            header("Content-Type: text/html; charset=UTF-8");
            echo '请在系统中正确进行请求！';
        }
    }

}
?>
