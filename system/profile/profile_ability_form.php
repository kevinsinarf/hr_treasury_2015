<?php
$path = "../../";
include($path."include/config_header_top.php");
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

//POST
$PER_ID=$_POST['PER_ID'];
$ABIHIS_ID=$_POST['ABIHIS_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT ABIHIS_ID,PER_ID,ABIHIS_SEQ,ABILITY_ID,ABIHIS_DESC,ABIHIS_NOTE,ACTIVE_STATUS
FROM PER_ABILITY  where DELETE_FLAG = '0' AND ABIHIS_ID = '".$ABIHIS_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//ทักษะพิเศษ
$arr_ability=GetSqlSelectArray("ABILITY_ID", "ABILITY_NAME_TH", "SETUP_ABILITY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "ABILITY_NAME_TH");
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
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
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
<script src="js/profile_ability_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_ability_disp.php?<?php echo url2code($link2); ?>">ประวัติความสามารถพิเศษ</a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_ability_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT?>">
        <input type="hidden" id="ABIHIS_ID" name="ABIHIS_ID"  value="<?php echo $ABIHIS_ID; ?>">
           
       <div class="row formSep">
            <div class="col-md-2 col-sm-2" style="white-space:nowrap;">ทักษะพิเศษ : <span style="color:red;">*</span></div>
            <div class="col-md-3 col-sm-2"><?php echo GetHtmlSelect('ABILITY_ID','ABILITY_ID',$arr_ability,"ทักษะพิเศษ",$rec['ABILITY_ID'],'onchange=\'getTitle();\'','','1');?></div>  
        </div>
          
        <div class="row formSep">
            <div class="col-md-2 col-sm-2" style="white-space:nowrap;">รายละเอียด :</div>
            <div class="col-md-3 col-md-5"><textarea id="ABIHIS_DESC" name="ABIHIS_DESC" class="form-control" placeholder="รายละเอียด" maxlength="255" rows="3"><?php echo text($rec['ABIHIS_DESC']); ?></textarea></div>
        </div>
         
        <div class="row formSep">	
            <div class="col-md-2 col-sm-2" style="white-space:nowrap;">หมายเหตุ :</div>
            <div class="col-md-3 col-md-5"><textarea id="ABIHIS_NOTE" name="ABIHIS_NOTE" class="form-control" placeholder="หมายเหตุ" maxlength="255" rows="3"><?php echo text($rec['ABIHIS_NOTE']); ?></textarea></div>
        </div>		
    
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;:&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">
                <label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label>
            </div>
        </div>
         
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" 
          onClick="self.location.href='profile_ability_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <br>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>