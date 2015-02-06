<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
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
//POST
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
//MAIN
$sql = "SELECT a.MISS_ID, a.MISS_SEQ, a.MISS_TYPE, a.MISS_SDATE, a.MISS_EDATE, a.MISS_LAST_SALARY, a.MISS_NEW_SALARY, a.MISS_NOTE, a.ACTIVE_STATUS
FROM PER_MISSSALHIS a 
WHERE a.DELETE_FLAG='0' AND a.MISS_ID = '".$MISS_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$rec["MISS_LAST_SALARY"] = empty($rec["MISS_LAST_SALARY"])?$db->get_data_field("SELECT PER_SALARY FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ", "PER_SALARY"):$rec["MISS_LAST_SALARY"];
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_missalhis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li><a href="profile_missalhis_disp.php?<?php echo url2code($link2); ?>">ประวัติการไม่ได้รับเงินเดือน</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
    <div class="clearfix"></div>
    <form id="frm-input" method="post" action="process/profile_missalhis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="MISS_ID" name="MISS_ID" value="<?php echo $MISS_ID?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทความเคลื่อนไหว : <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php  echo GetHtmlSelectNoConv('MISS_TYPE','MISS_TYPE',$arr_miss_type,'ประเภทความเคลื่อนไหว',$rec["MISS_TYPE"],'','','1');?></div>
        </div>
                
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่เริ่มต้น :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <input type="text" id="MISS_SDATE" name="MISS_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["MISS_SDATE"]==''?'':conv_date(text($rec["MISS_SDATE"]),''); ?>" >
                    <span class="input-group-addon datepicker" for="MISS_SDATE">&nbsp;
                        <span id="sdate" class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>				
            </div>
			<div class="col-xs-12 col-md-2"></div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่สิ้นสุด :&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2">	
                <div class="input-group">
                    <input type="text" id="MISS_EDATE" name="MISS_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["MISS_EDATE"]==''?'':conv_date(text($rec["MISS_EDATE"]),''); ?>">
                    <span class="input-group-addon datepicker" for="MISS_EDATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>	
            </div>			
		</div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือนปกติ  :  <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2"><input type="text" id="MISS_LAST_SALARY" name="MISS_LAST_SALARY" class="form-control" placeholder="เงินเดือนปกติ" value="<?php echo number_format($rec['MISS_LAST_SALARY'], 2); ?>" style="text-align:right" onBlur="NumberFormat(this,2);" ></div>
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือนที่จ่ายจริง  :  <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2"><input type="text" id="MISS_NEW_SALARY" name="MISS_NEW_SALARY" class="form-control" placeholder="เงินเดือนที่จ่ายจริง" value="<?php echo number_format($rec['MISS_NEW_SALARY'], 2); ?>" style="text-align:right" onBlur="NumberFormat(this,2);"></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ  : &nbsp;</div>
            <div class="col-xs-12 col-md-6"><textarea id="MISS_NOTE" name="MISS_NOTE" class="form-control" placeholder="หมายเหตุ" maxlength="255" rows="3"><?php echo text($rec['MISS_NOTE']); ?></textarea></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-3">
                <label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> ใช้งาน </label>&nbsp;&nbsp;
                <label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > ไม่ใช้งาน </label>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12" align="center">
			<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			<button type="button" class="btn btn-default" onClick="self.location.href='profile_missalhis_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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