<?php
//日期功能模块
class DateModel extends Model {
    /*方法        isDate
     *功能        判断日期格式是否正确
      *参数        $str  日期字符串
                   $format  日期格式
      *返回        无
        */
    function isDate($str,$format="Y-m-d"){
        $unixTime=strtotime($str);
        $checkDate= date($format,$unixTime);
        if($checkDate==$str)
             return true;
        else
             return false;
        }
     function get_time_k($str)  //传递日期，转换成秒
     {
         list($year,$month,$day)=split ("-",$str);
         return mktime(0,0,0,$month,$day,$year);
     }
     function get_time_j($str)  //传递日期，转换成秒
     {
         list($year,$month,$day)=split ("-",$str);
         return mktime(23,59,59,$month,$day,$year);
     }
     function get_date($time)    //传递秒数，获取日期
     {
        return date( 'Y-m-d H:i:s', $time);
     }


     function array_timetodate($list,$kind='input_time')   //将二维数组中的数据转为日期
     {
         for($i=0;$i<count($list);$i++)
         {
             $list[$i][$kind]=$this->get_date($list[$i][$kind]);
          }
          return $list;
     }

}
?>
