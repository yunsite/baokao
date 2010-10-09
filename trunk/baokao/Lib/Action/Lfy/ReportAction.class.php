<?php
/**
 * 报表统计类
 *
 * @author lanfengye2008
 */
class ReportAction extends Action{
    function _initialize()  //初始化
    {
         $Login=D('Admin.Login');
         $Login->check_admin();
    }
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

    /**
     * 未合格名单报表
     */

    function nohege_report(){
        $Stu_info=M('Stu_info');
        //获取学生信息表中不重复的年级列表并赋值到模板
        $this->assign('year_list', $Stu_info->field('distinct stu_join')->select());
        //获取学生信息表中不重复的系别列表并赋值到模板
        $this->assign('depart_list', $Stu_info->field('distinct depart_name')->select());

        /**
         * 进行处理获取到的查询条件数据
         */
        $year=addslashes($_GET['year']);
        $depart=addslashes($_GET['depart']);

        //如果年级和系别为空，则默认赋值为选择
        if($year==''){
            $year='select';
        }
        if($depart==''){
            $depart='select';
        }
        //对选择全部年级的情况进行处理
        if($year=='all'){
            $year_sql='';
        }else{
            $year_sql=" and stu_join='{$year}'";
        }
        //对选择全部系别的时候进行处理
        if($depart=='all'){
            $depart_sql='';
        }else{
            $depart_sql=" and depart_name='{$depart}'";
        }
        //输出当前查询的年级和系别
        $this->assign('year', $year);
        $this->assign('depart', $depart);

        //如果年级和系别有一个未选择，则不进行进一步的查询操作
        if($year!='select' || $depart!='select'){
            //使用原生sql语句查询排除合格表的记录
            $sql = "SELECT stu_no,stu_name,stu_sex,depart_name,stu_class,"
            ."stu_join,"
            ."((select bk_num from lfy_bk_num where lfy_bk_num.stu_join=lfy_stu_info.stu_join)"
            ."-(select count(stu_no) from lfy_stubk_temp where lfy_stubk_temp.stu_no=lfy_stu_info.stu_no)) num "
            ."from lfy_stu_info "
            ."where 1 and 1 {$year_sql}{$depart_sql} "
            ."and NOT EXISTS (SELECT * FROM lfy_stu_hege WHERE lfy_stu_hege.stu_no = lfy_stu_info.stu_no) "
            ."order by stu_join desc,depart_name,stu_class,stu_no desc";
            //$list=$Stu_info->query($sql);
            
            $this->assign('stu_list', $Stu_info->query($sql));
            //将当前的数量赋值到模板
            $this->assign('stu_num', count($list));
        }else{
            $this->assign('stu_num', 0);
        }
        
        $this->display();
    }
}
?>
