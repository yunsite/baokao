<?php
/**
 * 报表统计类
 *
 * @author lanfengye2008
 */
class ReportAction extends Action{
    /**
     * 各报考批次报表
     */
    function pici_report(){
        $pc_id=addslashes($_GET['id']);

        //判断pc_id是否为数值型
        if((!is_numeric($pc_id)) || $pc_id==''){
            $pc_id=0;
        }
        //输出当前查询的pc_id，以便于下拉框显示当前查询项
        $this->assign('pc_id', $pc_id);

        $Stu_info=M('Stu_info');

        $stu_list=$Stu_info->table('lfy_stu_info,lfy_stubk_temp,lfy_pici')->order('depart_name,stu_class,lfy_stu_info.stu_no desc')->where("lfy_stu_info.stu_no=lfy_stubk_temp.stu_no and lfy_stubk_temp.pc_id=lfy_pici.pc_id and lfy_pici.pc_id={$pc_id}")->select();
        //将查询到的结果数组赋值到模板
        $this->assign('stu_list', $stu_list);

        //将查询到的学生的数量赋值到模板
        $this->assign('stu_num', count($stu_list));


        //获取全部的批次列表
        $Pc=M('Pici');
        $this->assign('pc_list', $Pc->order('pc_id desc')->select());


        $this->display();
    }

    /**
     * 各批次合格报表
     */
    function hege_report(){
        $pc_id=addslashes($_GET['id']);

        //判断pc_id是否为数值型
        if((!is_numeric($pc_id)) || $pc_id==''){
            $pc_id=0;
        }
        //输出当前查询的pc_id，以便于下拉框显示当前查询项
        $this->assign('pc_id', $pc_id);

        $Stu_info=M('Stu_info');

        //判断是否为显示全部合格名单
        if($pc_id==0.1){
            $sql='';
        }else{
            $sql=" and lfy_pici.pc_id={$pc_id}";
        }

        $stu_list=$Stu_info->table('lfy_stu_info,lfy_stu_hege,lfy_pici')->order('depart_name,stu_class,lfy_stu_info.stu_no desc')->where("lfy_stu_info.stu_no=lfy_stu_hege.stu_no and lfy_stu_hege.pc_id=lfy_pici.pc_id{$sql}")->select();
        //将查询到的结果数组赋值到模板
        $this->assign('stu_list', $stu_list);

        //将查询到的学生的数量赋值到模板
        $this->assign('stu_num', count($stu_list));

        //获取全部的批次列表
        $Pc=M('Pici');
        $this->assign('pc_list', $Pc->order('pc_id desc')->select());

        
        $this->display();
    }
}
?>
