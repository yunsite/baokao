<?php
//系统公有类

class PublicAction extends Action{
    
    public function view_key(){        //显示验证码方法
		import("ORG.Util.Image");
		Image::buildImageVerify();
	}
}
?>