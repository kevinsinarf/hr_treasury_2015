<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);


 $proc = $_POST['proc'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";
$sub_menu = "ส่วนราชการที่มีชื่อเรียกอย่างอื่น";
$MAN_BDG_ID = $_POST['MAN_BDG_ID'];

if($proc=='edit'){	
	$sql = "SELECT *
	FROM SETUP_MANPOWER_BUDGET
	 WHERE MAN_BDG_ID='".$MAN_BDG_ID."'";
	$query = $db->query($sql); 
	$rec = $db->db_fetch_array($query);
}

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
<script src="js/man_budget_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">โครงสร้างและอัตรากำลัง</a></li>
			<li><a href="man_budget_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
			<li class="active"><?php echo $txt; ?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata" >
			<form id="frm-input" method="post" action="process/man_budget_process.php">
				<input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
				<input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
				<input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
				<input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
				<input name="MAN_BDG_ID" type="hidden" id="MAN_BDG_ID" value="<?php echo $MAN_BDG_ID; ?>">
				
                <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap;">แหล่งของเงิน : <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3"><input type="text" name="MAN_BDG_NAME_TH" placeholder="แหล่งของเงิน" id="MAN_BDG_NAME_TH" value="<?php echo text($rec['MAN_BDG_NAME_TH']);?>" class="form-control"></div>

				</div>
			  


				<div class="formlast">
					<div class="col-xs-12 col-md-12" align="center">
					<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
					<button type="button" class="btn btn-default" onClick="self.location.href='ss_position_per_notation_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>