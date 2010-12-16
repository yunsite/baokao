$(function(){
        $('#stu_no').focus();
        $('#tijiao').click(function(){
            var stu_no=$('#stu_no').val();
            var stu_name=$('#stu_name').val();
            var yz_num=$('#yz_num').val();
            $('#tijiao').attr('disabled','disabled');
            $('#no_pop').html('');
            $('#name_pop').html('');
            $('#pop').html('');
            $('#yz_pop').html('');
            if(check(stu_no,stu_name,yz_num)){
                $.post("/index.php/index-check_info.shtml",{
                    'stu_no':stu_no,
                    'stu_name':stu_name,
                    'yz_num':yz_num
                },function(data){chuli(data.data);},'json');
            }
        });


        $('#chaxun').click(function(){
            var stu_no=$('#stu_no').val();
            var stu_name=$('#stu_name').val();
            var yz_num=$('#yz_num').val();
            $('#no_pop').html('');
            $('#name_pop').html('');
            $('#pop').html('');
            $('#yz_pop').html('');
            if(check(stu_no,stu_name,yz_num)){
                $.post("/index.php/index-chaxun.shtml",{
                    'stu_no':stu_no,
                    'stu_name':stu_name,
                    'yz_num':yz_num
                },function(data){chuli(data.data);},'json');
            }
        });


        function chuli(data){
            switch(data){
                case 0:
                    $('#yz_num').val('');
                    $('#yz_pop').html('X验证码错误');
                    h_pop('yz_pop');
                    $('#yz_num').focus();
                    $('#tijiao').attr('disabled','');
                    rest_yzkey();
                    break;
                case 1:
                    $('#stu_no').val('');
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('X该学生不存在！');
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
                case 2:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#name_pop').html('X姓名错误！');
                    h_pop('name_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_name').focus();
                    rest_yzkey();
                    break;
                case 3:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('X已经合格！');
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
                case 4:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('X违纪无法报考');
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
                case 5:
                    $('#yz_num').val('');
                    $('#no_pop').html('报考尚未开始！');
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#yz_num').focus();
                    rest_yzkey();
                    break;
                case 6:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('本次已经报考');
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
                case 7:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('该次报考人数已满');
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
                case 8:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('报考次数已经用尽');
    
                    h_pop('no_pop');
                    $('#tijiao').attr('disabled','');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
                case 10:
                    location.href="/index.php/index-ok.shtml";
                    break;
                case 11:
                    location.href="/index.php/index-jieguo.shtml";
                    break;
                default:
                    $('#stu_name').val('');
                    $('#yz_num').val('');
                    $('#no_pop').html('系统错误，请刷新网页后重新报考！');
                    h_pop('no_pop');
                    $('#stu_no').focus();
                    rest_yzkey();
                    break;
            }
        }


        function h_pop(str){
            $("#"+str).fadeIn("slow");
            $('#'+str).fadeOut(3000);
        }

        $('#yz_img_num').click(function(){
             rest_yzkey();
         });
         function rest_yzkey(){   {/*刷新验证码方法*/}
            var t=Math.random();
            var url="/index.php/public-view_key";
            var sr = url +'-rnd-';
            $("#yz_img_num").attr("src",sr+t);
        }

        function check(stu_no,stu_name,yz_num){
            if(stu_no==''){
                $('#no_pop').html('X必须填写！');
                h_pop('no_pop');
                $('#tijiao').attr('disabled','');
                $('#stu_no').focus();
                return false;
            }
            if(stu_name==''){
                $('#name_pop').html('X必须填写！');
                h_pop('name_pop');
                $('#tijiao').attr('disabled','');
                $('#stu_name').focus();
                return false;
            }
            if(yz_num==''){
                $('#yz_pop').html('X必须填写！');
                h_pop('yz_pop');
                $('#tijiao').attr('disabled','');
                $('#yz_num').focus();
                return false;
            }
            return true;
        }

        $('#pop').ajaxStart(function(){
            $('#pop').html('<img src="/images/loading.gif" />数据处理中！请稍后...');
            $('#pop').show();
        });

        $('#pop').ajaxStop(function(){
            $('#pop').hide();
        });

    });