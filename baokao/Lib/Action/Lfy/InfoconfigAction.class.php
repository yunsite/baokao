<?php
/**
 * 信息设置控制器类
 *
 * By. lanfengye2008
 */
class InfoconfigAction extends Action{
    /**
     * 学生信息管理页面
     */
    function stu_info_manger(){
        $Stu_info=M('Stu_info');
        $this->assign('join_list', $Stu_info->order('stu_join desc')->field('distinct stu_join')->select());
        $this->assign('depart_list', $Stu_info->order('depart_name')->field('distinct depart_name')->select());


        $this->display();
    }

//    /**
//     * 根据系别名称进行获取该系别下的所有专业
//     */
//    function get_depart_class(){
//        //获取传递过来的系别名称
//        $depart_name=addslashes($_GET['depart']);
//        $Stu_info=M('Stu_info');
//        $str=json_encode($Stu_info->order('stu_class desc')->field('distinct stu_class')->where("depart_name='{$depart_name}'")->select());
//        //输出json编码后的子栏目序列
//        echo $str;
//    }
}
?>
