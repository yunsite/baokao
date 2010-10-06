<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BkModelclass
 *
 * 报考信息获取模块
 */
class BkModel extends Model {
    function get_info($str='',$limit=''){
        $sql="select * from lfy_student,lfy_zhuanye where "
        ."lfy_student.zy_no=lfy_zhuanye.zy_no {$str}  order by lfy_zhuanye.zy_no,lfy_student.input_time desc {$limit}";
        return $this->query($sql);
    }
}
?>
