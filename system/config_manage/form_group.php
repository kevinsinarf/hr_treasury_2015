<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

$sql = "select * from aut_group where user_group_id = '".$user_group_id."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$rec = @array_change_key_case($rec,CASE_LOWER);
$group_name = text($rec["group_name"]);
$active_status = (empty($rec["active_status"])) ? 1:$rec["active_status"];
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/disp_group.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div style="height:45em;">
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="disp_group.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id); ?>">กลุ่มสิทธิการใช้งาน </a></li>
          <li class="active"><?php echo $txt; ?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" > 
            <form id="frm-input" method="post" action="process/process_group.php">
            	<input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="user_group_id" type="hidden" id="user_group_id" value="<?php echo $user_group_id; ?>" />
                <input name="flagDup" type="hidden" id="flagDup">
                <div class="col-xs-3 col-sm-1" style="white-space:nowrap">ชื่อกลุ่ม&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                <span id="chkDup" class="col-xs-6 visible-xs label"></span>
                <div class="col-xs-12 col-sm-6"><input id="group_name" type="text" name="group_name" class="form-control" placeholder="ชื่อกลุ่ม" value="<?php echo $group_name; ?>"></div>
                <span id="chkDup" class="col-sm-2 hidden-xs label"></span>
                <div class="clearfix"></div><br>
                <div class="col-xs-12 col-sm-1" style="white-space:nowrap">สถานะ&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                <div>
                <label class="col-xs-12 col-sm-3">
                    <div class="input-group">
                      <span class="input-group-addon"><input name="active_status" type="radio" id="active_status" <?php echo ($active_status == 1) ? "checked":""; ?> value="1"></span>
                      <input id="active_status_1" type="text" name="active_status_1" class="form-control" value="ใช้งาน" readonly style="cursor:default;">
                    </div>
                </label>
                </div>
                <div>
                <label class="col-xs-12 col-sm-3">
                    <div class="input-group">
                      <span class="input-group-addon"><input name="active_status" type="radio" id="active_status" <?php echo ($active_status == 0) ? "checked":""; ?> value="0"></span>
                      <input id="active_status_0" type="text" name="active_status_0" class="form-control" value="ไม่ใช้งาน" readonly style="cursor:default;">
                    </div>
                </label>
                </div>
                <div class="clearfix"></div><br>
                <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                <button type="button" class="btn btn-default" onClick="self.location.href='disp_group.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
                </div>
                <div class="clearfix"></div><br>                                
			</form>
        </div>
    </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html> 