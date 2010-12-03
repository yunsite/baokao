<?php
/**
 * 模块功能：数据导入控制器
 *
 * zibin_5257@163.com   BY.lanfengye
 * QQ:83429645
 **/
class ImportAction extends Action{

    function _initialize()  //初始化
    {
         $Login=D('Admin.Login');
         $Login->check_admin();
    }


    /**
     * 通用excel文件上传界面
     */
    function stu(){

        
        $this->display();
    } 
    /**
     * 学生基础数据导入逻辑
     */
    function import_stu(){
        define('DIR', './Public/Uploads/stu_info.xls');
        //新建一个数据模型
        $Stu_info=M('Stu_info');
        header("Content-Type: text/html; charset=UTF-8");
        import ( "@.ORG.Phpexcel" );

        $PHPExcel = new PHPExcel(); 
        $PHPReader = new PHPExcel_Reader_Excel5();
        if(!file_exists(DIR)){
            echo '<script language="javascript">'
            .'alert("导入基础名单的EXCEL文件不存在，请正确上传后在执行导入操作！");'
            .'location.href="'.U('import/stu').'";'
            .'</script>';
            exit ();
        }else{
            if(!$PHPReader->canRead(DIR)){      //如果还不对，输出没有excel
                echo '<script language="javascript">'
            .'alert("EXCEL格式错误，请使用EXCEL2003创建或修改的文件！");'
            .'location.href="'.U('import/stu').'";'
            .'</script>';
            exit ();
            }
        }
        $PHPExcel = $PHPReader->load(DIR);
        $currentSheet = $PHPExcel->getSheet(0); //取得excel工作“分页”
        
         /**取得一共有多少行*/
        $allRow = $currentSheet->getHighestRow();
        /**取得一共有多少列*/
        $allColumn = $currentSheet->getHighestColumn();
        //成功的数量
        $ok_count=0;
        $count=0;
        
        for ($i = 3; $i <=$allRow; $i++){
        //$i=3 1行标题，2行版权声明
            for($j='A';$j<=$allColumn;$j++){
                $str.=$currentSheet->getCell($j.$i)->getValue().',';
            }
            //explode:函数把字符串分割为数组。
            $strs = explode(",",$str);
            $temp_data['stu_no']=$strs[0];
            $temp_data['stu_name']=$strs[1];
            $temp_data['stu_sex']=$strs[2];
            $temp_data['depart_name']=$strs[3];
            $temp_data['stu_class']=$strs[4];
            $temp_data['stu_join']=$strs[5];
            
            if($temp_data['stu_no']=='' or $temp_data['stu_name']=='' or $temp_data['stu_sex']=='' or $temp_data['depart_name']=='' or $temp_data['stu_class']=='' or $temp_data['stu_join']==''){
                echo '<font color="blue">第'.$count.'条数据错误.学号：'.$temp_data['stu_no'].'-姓名：'.$temp_data['stu_name'].'&nbsp;&nbsp;&nbsp;&nbsp;存在空字段！</font><br />';
            }
            else{
                if($Stu_info->where("stu_no='{$temp_data['stu_no']}'")->count()>0){
                    echo '<font color="red">第'.$count.'条数据错误.学号：'.$temp_data['stu_no'].'-姓名：'.$temp_data['stu_name'].'&nbsp;&nbsp;&nbsp;&nbsp;重复的记录！</font><br />';
                }else{
                    $ok_count++;
                    $Stu_info->add($temp_data);
                    echo $count.'.学号：'.$temp_data['stu_no'].'-姓名：'.$temp_data['stu_name'].'&nbsp;&nbsp;&nbsp;&nbsp;导入成功！<br />';
                }
            }
            echo '<br />';
            $count++;
            $str='';
        }
        $allRow-=2;
        echo "<br /><br /><font color='red'>共计执行【{$allRow}】次导入</font>";
        echo "<br /><font color='red'>成功导入【{$ok_count}】条数据</font>";
        echo "<br /><font color='red'>导入失败【".($allRow-$ok_count)."】条数据</font>";
        unlink(DIR);   //导入完成后删除上传的EXCEL文件  
    }
    
    /**
     * 新的合格学生导入逻辑
     */
    public function import_hege(){
        //定义文件的路径
        define('DIR', './Public/Uploads/stu_hege.xls');
        //新建一个数据模型
        $Stu_hege=M('Stu_hege');
        header("Content-Type: text/html; charset=UTF-8");
        import ( "@.ORG.Phpexcel" );

        $PHPExcel = new PHPExcel();
        $PHPReader = new PHPExcel_Reader_Excel5();
        if(!file_exists(DIR)){
            echo '<script language="javascript">'
            .'alert("导入合格名单的EXCEL文件不存在，请正确上传后在执行导入操作！");'
            .'location.href="'.U('import/hege').'";'
            .'</script>';
            exit ();
        }else{
            if(!$PHPReader->canRead(DIR)){      //如果还不对，输出没有excel
                echo '<script language="javascript">'
            .'alert("EXCEL格式错误，请使用EXCEL2003创建或修改的文件！");'
            .'location.href="'.U('import/hege').'";'
            .'</script>';
            exit ();
            }
        }
        
        $PHPExcel = $PHPReader->load(DIR);
        $currentSheet = $PHPExcel->getSheet(0); //取得excel工作“分页”

         /**取得一共有多少行*/
        $allRow = $currentSheet->getHighestRow();
        /**取得一共有多少列*/
        $allColumn = $currentSheet->getHighestColumn();
        //成功的数量
        $ok_count=0;
        $count=0;

        for ($i = 3; $i <=$allRow; $i++){
        //$i=3 1行标题，2行版权声明
            for($j='A';$j<=$allColumn;$j++){
                $str.=$currentSheet->getCell($j.$i)->getValue().',';
            }
            //explode:函数把字符串分割为数组。
            $strs = explode(",",$str);
            $temp_data['stu_no']=$strs[0];
            $temp_data['pc_id']=$strs[1];
            $temp_data['hg_num']=$strs[2];

            if($temp_data['stu_no']=='' or $temp_data['pc_id']==''){
                echo '<font color="blue">第'.$count.'条数据错误.学号：'.$temp_data['stu_no'].'&nbsp;&nbsp;&nbsp;&nbsp;存在空字段！</font><br />';
            }
            else{
                if($Stu_hege->where("stu_no='{$temp_data['stu_no']}'")->count()>0){
                    echo '<font color="red">第'.$count.'条数据错误.学号：'.$temp_data['stu_no'].'&nbsp;&nbsp;&nbsp;&nbsp;重复的记录！</font><br />';
                }else{
                    $ok_count++;
                    $Stu_hege->add($temp_data);
                    echo $count.'.学号：'.$temp_data['stu_no'].'&nbsp;&nbsp;&nbsp;&nbsp;导入成功！<br />';
                }
            }
            echo '<br />';
            $count++;
            $str='';
        }
        $allRow-=2;
        echo "<br /><br /><font color='red'>共计执行【{$allRow}】次导入</font>";
        echo "<br /><font color='red'>成功导入【{$ok_count}】条数据</font>";
        echo "<br /><font color='red'>导入失败【".($allRow-$ok_count)."】条数据</font>";

        unlink(DIR);   //导入完成后删除上传的EXCEL文件
    }


    function import_weiji(){
        import ( "@.ORG.Reader" );
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');
        //”data.xls”是指要导入到mysql中的excel文件
        $dir="./Public/Uploads/stu_weiji.xls";
        $data->read($dir);
        //统计总计导入的数据数量
        $count=0;
        //成功的数量
        $ok_count=0;


        //新建一个数据模型
        $Stu_info=M('Stu_weiji');
        for ($i = 3; $i <=$data->sheets[0]['numRows']; $i++){
        //$i=3 是空2行   不带标题行就是$i=1
            //$data->sheets[0]['cells'][$i][1]."','".//id

            $temp_data['stu_no']=$data->sheets[0]['cells'][$i][1];
            $temp_data['pc_id']=$data->sheets[0]['cells'][$i][2];
            $temp_data['off']=$data->sheets[0]['cells'][$i][3];
            $temp_data['beizhu']=$data->sheets[0]['cells'][$i][3];
            $count++;
            if($temp_data['stu_no']=='' or $temp_data['pc_id']=='' or ($temp_data['off']!='t' and $temp_data['off']!='f')){
                echo '<font color="blue">第'.$count.'条数据错误.学号：'.$temp_data['stu_no'].'&nbsp;&nbsp;&nbsp;&nbsp;字段值错误或存在空字段！</font><br />';
            }
            else{
                if($Stu_info->where("stu_no='{$temp_data['stu_no']}' and pc_id={$temp_data['pc_id']}")->count()>0){
                    echo '<font color="red">第'.$count.'条数据错误.学号：'.$temp_data['stu_no'].'&nbsp;&nbsp;&nbsp;&nbsp;重复的记录！</font><br />';
                }else{
                    $ok_count++;
                    $Stu_info->add($temp_data);
                    echo $count.'.学号：'.$temp_data['stu_no'].'&nbsp;&nbsp;&nbsp;&nbsp;导入成功！<br />';
                }
            }


        }

        echo "<br /><br /><font color='red'>共计执行【{$count}】次导入</font>";
        echo "<br /><font color='red'>成功导入【{$ok_count}】条数据</font>";
        echo "<br /><font color='red'>导入失败【".($count-$ok_count)."】条数据</font>";



    }

    //excel文件上传
    function upload_stu(){
        if(!empty($_FILES)) {
                //如果有文件上传 上传附件
                $this->_upload();
        }else{
            $this->display();
        }

    }


    // 文件上传组件
    protected function _upload($url='./Public/Uploads/')
    {
        import("ORG.Net.UploadFile");
        $upload = new UploadFile();
        //设置上传文件大小  单位Byte  当前小于200Kb
        $upload->maxSize  = 20480000 ;
        //设置上传文件类型
        $upload->allowExts  = explode(',', 'jpg,xls');; // 设置附件上传类型
        $upload->uploadReplace=true;  //同名文件覆盖
        //设置附件上传目录
        $upload->savePath =  "{$url}";

	
	   if(!$upload->upload()) { // 上传错误提示错误信息！
               $this->display('Lfy:Import:upload_error');
               dump($upload->getErrorMsg());
		}else{ // 上传成功获取上传文件信息
                    $this->display('Lfy:Import:upload_sussful');
		}

        }


}
?>
