<?php
class LoginModel extends Action{
        //检测管理员是否正确登陆了系统
	public function check_admin()
	{
		if(!Session::is_set('lfy_name') or !Session::is_set('lfy') or $_SESSION['lfy']!=md5('lfy000'))
		{
			$this->redirect('index/index');
			exit();
		}
	}
}
?>
