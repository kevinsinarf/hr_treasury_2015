<?php
$path = "../../";
include($path."include/config_header_top.php");
//echo $PER_ID;
$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}
$paramlink = url2code($link);
$path_img='../fileupload/profile_his/';
//POST
$ATTENTYPE_ID=$_POST['ATTENTYPE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"; 

//DATA
$sql = "select * FROM PER_PICTURE where PIC_ID = '".$PIC_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//สถานะการใช้ภาพถ่าย  
$arr_pic_status = array('1'=>"เป็นภาพปัจจุบัน", '2'=>"ไม่เป็นภาพปัจจุบัน");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_picture.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
            <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
            
            <li><a href="profile_picture.php?<?php echo url2code($link2); ?>">ประวัติภาพถ่าย</a></li>
            <li class="active"><?php echo $txt; ?></li>
        </ol>
  	</div>
    <div class="col-xs-12 col-sm-12" id="content">
    	<div class="groupdata" ><br>
        <?php include ("tab_info.php"); ?>
		<div class="clearfix"></div>
           
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
                <input type="hidden" id="PIC_ID" name="PIC_ID" value="<?php echo $PIC_ID; ?>">
				<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
				
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่ถ่ายภาพ : &nbsp; </div>
                    <div class="col-xs-12 col-md-2">
                    	<div class="input-group">
                             <?php echo $rec["PIC_DATE"]==''?'':conv_date(text($rec["PIC_DATE"]),''); ?> 
                        </div>
                    </div>
				</div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ภาพถ่าย :&nbsp; &nbsp; </div>
                    <div class="col-xs-12 col-md-3">
                		<div class="input-group"  >
                        
                        <!--img src="../../fileupload/profile_his/<?php echo text($rec["PIC_FILENAME"]); ?>" height="100"  -->   
                            <input type="file" id="PIC_FILENAME" name="PIC_FILENAME" class="form-control"  value="" placeholder="ภาพถ่าย" style="display:none;" >
                            <?php echo displayDownloadFileAttach($path_img,$rec['PIC_FILEPATH'],$arr_txt['download']);?>
                        </div>
                        <input type="hidden" id="OLD_FILENAME" name="OLD_FILENAME"   value="<?php echo text($rec["PIC_FILENAME"]); ?>">
                        <input type="hidden" id="OLD_FILEPATH" name="OLD_FILEPATH"   value="<?php echo text($rec["PIC_FILEPATH"]); ?>">
                 	</div>
				</div>

				<div class="row formSep">
                    <div class="col-xs-2 col-md-2 " style="white-space:nowrap">หมายเหตุ :&nbsp; &nbsp; </div>
                    <div class="col-xs-6 col-md-6"> <?php echo text($rec['PIC_REMARK']); ?></div> 
				</div>
               
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถานะการใช้ภาพถ่าย :&nbsp;&nbsp;</div>
                    <?php 
					if($rec['ACTIVE_STATUS']=="1" && $rec['PIC_DEFAULT']=="1"){ ?>
                    <div class="col-xs-6 col-md-2">
					<?php echo $arr_pic_status[$rec['PIC_DEFAULT']];?>
						<input type="hidden" id="PIC_DEFAULT" name="PIC_DEFAULT"  value="<?php echo $rec['PIC_DEFAULT'];?>" >
                   	</div>
						<?php }else{?>
                   	<div class="col-xs-6 col-md-2">
             			<label ><input type="radio" disabled id="PIC_DEFAULT1" name="PIC_DEFAULT"  value="1" <?php echo ($rec['PIC_DEFAULT']=='1'?"checked":"")?>> <?php echo $arr_pic_status['1'];?></label>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <label ><input type="radio" disabled id="PIC_DEFAULT2" name="PIC_DEFAULT"  value="2" <?php echo ($rec['PIC_DEFAULT']=='2' || $rec['PIC_DEFAULT']==''?"checked":"")?>> <?php echo $arr_pic_status['2'];?></label>
                    </div>
                   	<?php } ?>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?> :&nbsp;&nbsp;</div>
                    <div class="col-xs-6 col-md-2">
                        <label ><input type="radio" disabled id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <label ><input type="radio" disabled id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label>
                    </div>
                </div>
                 
		</div> 
        </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</div>
</body>
</html>