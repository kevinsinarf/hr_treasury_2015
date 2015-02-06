<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

$page_back = "pos_type_setup_disp.php";

//POST
$TYPE_ID=$_POST['TYPE_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
 $sql = "SELECT * FROM SETUP_POS_TYPE  where DELETE_FLAG = '0' AND TYPE_ID = '".$TYPE_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

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
<script src="js/pos_type_setup.js?<?php echo rand(); ?>"></script>
</head>
<body>
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
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" >
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/pos_type_setup_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="TYPE_ID" name="TYPE_ID"  value="<?php echo $TYPE_ID; ?>">
        <input type="hidden" id="flagDup1" name="flagDup1" >
        <input type="hidden" id="flagDup2" name="flagDup2" > 
        <input type="hidden" id="flagDup3" name="flagDup3" >
        <input type="hidden" id="flagDup4" name="flagDup4" >
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" >ชื่อกลุ่มงานภาษาไทย : <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="TYPE_NAME_TH" name="TYPE_NAME_TH" class="form-control" placeholder="ชื่อกลุ่มงานภาษาไทย" maxlength="100" value="<?php echo text($data["TYPE_NAME_TH"]); ?>" onKeyUp="chkDup('chkDup1','flagDup1','TYPE_NAME_TH','TYPE_ID','SETUP_POS_TYPE','POSTYPE_ID=5');"></div>
                <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
                <div class="col-xs-12 col-md-2">ชื่อย่อกลุ่มงานภาษาไทย : </div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="TYPE_SHORTNAME_TH" name="TYPE_SHORTNAME_TH" class="form-control" placeholder="ชื่อย่อกลุ่มงานภาษาไทย" maxlength="20" value="<?php echo text($data["TYPE_SHORTNAME_TH"]); ?>" onKeyUp="chkDup('chkDup2','flagDup2','TYPE_SHORTNAME_TH','TYPE_ID','SETUP_POS_TYPE','POSTYPE_ID=5');"></div>
                <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
               </div> 
               
             <div class="row formSep">   
			<div class="col-xs-12 col-md-2 ">ชื่อกลุ่มงานภาษาอังกฤษ : </div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="TYPE_NAME_EN" name="TYPE_NAME_EN" class="form-control" placeholder="ชื่อกลุ่มงานภาษาอังกฤษ" maxlength="100" value="<?php echo text($data["TYPE_NAME_EN"]); ?>" onKeyUp="chkDup('chkDup3','flagDup3','TYPE_NAME_EN','TYPE_ID','SETUP_POS_TYPE','POSTYPE_ID=5');"></div>
                <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
                <div class="col-xs-12 col-md-2 " >ชื่อย่อกลุ่มงานภาษาอังกฤษ : </div>
			<div class="col-xs-12 col-md-2">
				<input type="text" id="TYPE_SHORTNAME_EN" name="TYPE_SHORTNAME_EN" class="form-control" placeholder="ชื่อย่อกลุ่มงานภาษาอังกฤษ" maxlength="20" value="<?php echo text($data["TYPE_SHORTNAME_EN"]); ?>" onKeyUp="chkDup('chkDup4','flagDup4','TYPE_SHORTNAME_EN','TYPE_ID','SETUP_POS_TYPE','POSTYPE_ID=5');"></div>
                <span id="chkDup4" class="col-sm-2 hidden-xs label"></span>
                </div>
                
        <div class="row formSep">
              <div class="col-xs-12 col-md-2 " >ลำดับที่ใช้ในการจัดเรียง : </div>
              <div class="col-xs-12 col-md-2">
				<input type="text" id="TYPE_SEQ" name="TYPE_SEQ" class="form-control" placeholder="ลำดับที่ใช้ในการจัดเรียง" maxlength="20" value="<?php echo text($data["TYPE_SEQ"]); ?>" style="width:100px;" >
                </div>
                <div class="col-xs-12 col-md-2"></div>
              <div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;: <span style="color:red;">*</span>&nbsp;</div>
              <div class="col-xs-12 col-md-2">
                  <label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($data['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($data['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
          </div>
                
		<div class="clearfix"></div><br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='pos_type_setup_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <div class="clearfix"></div>
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