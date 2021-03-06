<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

$page_back = "setup_org_type_disp.php";

//POST
$OT_ID=$_POST['OT_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
 $sql = "SELECT * FROM SETUP_ORG_TYPE  where DELETE_FLAG = '0' AND OT_ID = '".$OT_ID."'";
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
<script src="js/setup_org_type.js?<?php echo rand(); ?>"></script>
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
    <div class="groupdata" ><br>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/setup_org_type_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="OT_ID" name="OT_ID"  value="<?php echo $OT_ID; ?>">
        <input type="hidden" id="flagDup1" name="flagDup1" >
        <input type="hidden" id="flagDup2" name="flagDup2" > 
        
		<div class="row formSep">
			<div class="col-xs-12 col-md-3" style="white-space:nowrap;">ชื่อประเภทส่วนราชการ (<?php echo $arr_txt['th'] ;?>) : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-4">
				<input type="text" id="OT_NAME_TH" name="OT_NAME_TH" class="form-control" placeholder="ชื่อประเภทส่วนราชการ (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["OT_NAME_TH"]); ?>" onKeyUp="chkDup('chkDup1','flagDup1','OT_NAME_TH','OT_ID','SETUP_ORG_TYPE','');"></div>
                <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
                </div>
                
             <div class="row formSep">   
			<div class="col-xs-12 col-md-3 " style="white-space:nowrap;">ชื่อประเภทส่วนราชการ (<?php echo $arr_txt['en'] ;?>) : </div>
			<div class="col-xs-12 col-md-4">
				<input type="text" id="OT_NAME_EN" name="OT_NAME_EN" class="form-control" placeholder="ชื่อประเภทส่วนราชการ (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["OT_NAME_EN"]); ?>" onKeyUp="chkDup('chkDup2','flagDup2','OT_NAME_EN','OT_ID','SETUP_ORG_TYPE','');"></div>
                <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
		</div>
                
        <div class="row formSep">
					<div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;: <span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-3">
						<label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($data['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
					
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($data['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
				</div>
                
		<div class="clearfix"></div><br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='setup_org_type_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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