<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$POSTYPE_ID=$_POST['POSTYPE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 


$sql=  " SELECT POSTYPE_ID,POSTYPE_CODE ,POSTYPE_NAME_TH,POSTYPE_NAME_EN,ACTIVE_BY FROM SETUP_POSITION_TYPE  WHERE  POSTYPE_ID ='".$POSTYPE_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
//$rec = @array_change_key_case($rec,CASE_LOWER);
$POSTYPE_ID = text($rec["POSTYPE_ID"]);
$POSTYPE_NAME_TH = text($rec["POSTYPE_NAME_TH"]);
$POSTYPE_NAME_EN = text($rec["POSTYPE_NAME_EN"]);
$ACTIVE_STATUS = ($proc == "add") ? 1:text($rec["ACTIVE_BY"]);
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
<script src="<?php echo $path; ?>js/func.js"></script>

<script src="js/position_type_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="position_type_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
		<form id="frm-input" method="post" action="process/position_type_process.php">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID; ?>">
        <input name="flagDup1" type="hidden" id="flagDup1">
        <input name="flagDup2" type="hidden" id="flagDup2">
		<div class="row formSep">
				<div class="col-xs-12 col-sm-3 " style="white-space:nowrap"><?php echo $arr_txt['type_pos'];?>บุคลากร&nbsp;(<?php echo $arr_txt['th'];?>)&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-12 col-sm-5">
                                    <span id="chkDup1" class="col-xs-9 visible-xs label"></span>
					<input type="text" id="POSTYPE_NAME_TH" name="POSTYPE_NAME_TH" maxlength="100" 
							class="form-control" 
                                                        placeholder="<?php echo $arr_txt['type_pos'];?>บุคลากร&nbsp;(<?php echo $arr_txt['th'];?>)" 
							value="<?php echo text($rec["POSTYPE_NAME_TH"]); ?>"
                                                         onkeyup="chkDup('chkDup1','flagDup1','POSTYPE_NAME_TH','POSTYPE_ID','SETUP_POSITION_TYPE','');">
				</div>
					<span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
		</div>
		<div class="row formSep">
				<div class="col-xs-12 col-sm-3" style="white-space:nowrap"><?php echo $arr_txt['type_pos'];?>บุคลากร&nbsp;(<?php echo $arr_txt['en'];?>)&nbsp;</div>
				<div class="col-xs-12 col-sm-5">
                                    <span id="chkDup2" class="col-xs-9 visible-xs label"></span>
					<input type="text" id="POSTYPE_NAME_EN" name="POSTYPE_NAME_EN" maxlength="100"
							class="form-control" 
                                                        placeholder="<?php echo $arr_txt['type_pos'];?>บุคลากร&nbsp;(<?php echo $arr_txt['en'];?>)" 
							value="<?php echo text($rec["POSTYPE_NAME_EN"]); ?>"
                                                         onkeyup="chkDup('chkDup2','flagDup2','POSTYPE_NAME_EN','POSTYPE_ID','SETUP_POSITION_TYPE','');">
				</div>
					<span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
		</div>
		<div class="row formSep">
				<div class="col-xs-4 col-md-3"> <?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
				<div class="col-xs-8 col-md-4">
						<label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($ACTIVE_STATUS=='1'?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
						<label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($ACTIVE_STATUS=='0'?"checked":"")?>> <?php echo $arr_act_status['0'];?></label>
				</div> 	
        </div>
		<div class="formlast">
				<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="	chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='position_type_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
				</div>
		</div>
      </form>
    </div>
  </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->