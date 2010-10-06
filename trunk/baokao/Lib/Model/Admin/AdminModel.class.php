<?php


//用户模型类
class AdminModel extends Model {
	function get_admin_name($id)   //根据用户id获取用户名
	{
		$list=$this->query("SELECT user_name FROM lfy_lanfengye where user_id={$id}");
		return $list[0][user_name];
	}
        function get_admin_id($name)   //根据用户name获取用户id
	{
		$list=$this->query("SELECT user_id FROM lfy_lanfengye where user_name='{$name}'");
		return $list[0]['user_id'];
	}
	function get_admin()   //获取用户列表
	{
		$list=$this->query("SELECT * FROM lfy_lanfengye");
		return $list;
	}

        //获取特定用户的信息
        function get_user_info($user_id)
        {
            $list=$this->query("SELECT * FROM lfy_lanfengye where user_id='{$user_id}'");
            return $list[0];
        }

        
        function check_admin_pwd($user_name,$user_pwd)  //检测原始密码是否正确  $user_name    $user_pwd
        {
            $list=$this->query("SELECT user_pwd FROM lfy_lanfengye where user_name='{$user_name}'");
            if(count($list)>0){
                if($list['0']['user_pwd']==$user_pwd)
                {   //原始密码正确
                    return true;
                }
                 else
                 {  //原始密码不正确
                    return false;
                 }
            }
            else
            {   //系统错误
                return 3;
            }
        }
        //保存更改的密码，$user_id 为用户ID，$user_pwd为md5加密的新密码
        function save_change_pwd($user_name,$user_pwd)
        {
            return $this->execute("UPDATE lfy_lanfengye SET user_pwd='{$user_pwd}' WHERE user_name='{$user_name}'");
        }

        
        //通过用户名确认该用户是否存在
        function count_admin($admin_name){
            $list=$this->query("select user_name from lfy_lanfengye where user_name='{$admin_name}'");
            if(count($list)>0)
                return 1;   //存在返回1
            else
                return 0;
        }



        function del_admin($id){   //根据类别id删除用户，无返回值
            $this->execute("delete from lfy_lanfengye where user_id={$id}");
        }


        /*
         * 方法说明：保存用户的部门
         * 参数说明:
         * int $user_id:用户ID
         * int $bm_id:部门ID
         */
        function save_user_bumen($user_id,$bm_id){
            $sql="insert into re_user_bumen "
            ."(user_id,bm_id) "
            ."values ({$user_id},{$bm_id})";
            $this->execute($sql);
        }

        //通过$user_id获取用户的部门列表
        function get_user_bumen($user_id){
            $sql="select distinct bm_name from re_bumen,re_user_bumen "
            ."where re_user_bumen.user_id={$user_id} and re_user_bumen.bm_id=re_bumen.bm_id";
            return $this->query($sql);
        }


        //保存更改的用户信息
        function save_user_info($u_name,$u_sex,$u_tel,$u_qq,$u_email,$u_come,$gongsi_name,$gongsi_jianjie,$user_id){
            $sql="update lfy_user set "
                ."u_name='{$u_name}',u_sex='{$u_sex}',u_tel='{$u_tel}',u_qq='{$u_qq}',u_email='{$u_email}',u_come='{$u_come}',gongsi_name='{$gongsi_name}',gongsi_jieshao='{$gongsi_jianjie}'"
                ." where user_id={$user_id}";
            return $this->execute($sql);
        }
}
?>